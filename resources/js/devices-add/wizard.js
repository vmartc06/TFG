import {checkEnrollment} from "./device-store.js";
import {AdbDaemonWebUsbDeviceObserver} from "@yume-chan/adb-daemon-webusb";

let enrollmentData = {
    "android.app.extra.PROVISIONING_DEVICE_ADMIN_COMPONENT_NAME": "com.martinez.victor.tfg_owner_app/.DeviceOwnerReceiver",
    "android.app.extra.PROVISIONING_DEVICE_ADMIN_PACKAGE_CHECKSUM": "AWT1p6-o-einSNpiSEYfgZUCl5ebCuS3dX-1v4xHRcU",
    "android.app.extra.PROVISIONING_DEVICE_ADMIN_PACKAGE_DOWNLOAD_LOCATION": "http://localhost:8000/app.apk",
    "android.app.extra.PROVISIONING_SKIP_ENCRYPTION": "true",
    "android.app.extra.PROVISIONING_LEAVE_ALL_SYSTEM_APPS_ENABLED": "true",
    "android.app.extra.PROVISIONING_ADMIN_EXTRAS_BUNDLE": {
        "server_url": "http://localhost:8000/api/v1",
        "registration_code": "63BB1015FF"
    }
};

let deviceName = "";

const devicesUSBObserver = await AdbDaemonWebUsbDeviceObserver.create(navigator.usb);

let step3Device = null
let step3PermissionsLock = false
let step3ADB = null
let step3HasDisconnected = false
let step3ProvisionStatus = false
let step3Provisioning = false
let step3EnrollmentStatus = false

$(function () {
    if (location.hash) {
        history.replaceState(null, document.title, location.pathname + location.search);
    }

    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'dots',
        autoAdjustHeight: false,
        showStepURLhash: false,
        toolbar: {
            showNextButton: false,
            showPreviousButton: false
        }
    });

    // STEP 1

    $("#btn-step-1a-next").on("click", async function () {
        registerDevice().then((data) => {
            deviceName = data.deviceName;
            enrollmentData = data.responseJSON;
            cleanError()
            $('#smartwizard').smartWizard("next");
            generateQR()
        }).catch(error => {
            showError(error);
        })
    })

    $("#btn-step-1b-next").on("click", async function () {
        if (!checkUSBSupport()) {
            showError("This browser is not compatible with manual enrollment")
            return
        }
        registerDevice().then((data) => {
            enrollmentData = data;
            cleanError()
            const wizard = $('#smartwizard')
            wizard.smartWizard("next");
            wizard.smartWizard("next");
            step3(-1)
            enrollDevice().then(() => {
                console.log("ENROLLED")
            }).catch(error => {
                showError(error);
            })
        }).catch(error => {
            showError(error);
        })
    })

    // STEP 2

    $("#btn-step-2-next").on("click", async function () {
        checkEnrollment(deviceName).then((deviceEnrolled) => {
            if (deviceEnrolled) {
                const wizard = $('#smartwizard');
                wizard.smartWizard("next")
                wizard.smartWizard("next")
                setTimeout(() => {
                    window.location.href = dashboardRoute
                }, 2500);
            } else {
                showError("You must finish the enrollment process on the phone to continue")
            }
        }).catch(error => {
            showError(error);
        })
    })

    // STEP 3

    const btnGrantDevicePermissions = document.getElementById("btn-grant-device-permissions");
    const btnEnrollDevice = document.getElementById("btn-enroll-device");
    const manualDeviceName = document.getElementById("manual-device-name");
    const deviceStepStatus = document.getElementById("device-step-status");
    const permissionStepStatus = document.getElementById("permission-step-status");
    const enrollStepStatus = document.getElementById("enroll-step-status");

    btnGrantDevicePermissions.disabled = true
    btnEnrollDevice.disabled = true

    $("#btn-select-device").on("click", async function () {
        selectUSBDevice().then((device) => {
            step3HasDisconnected = false
            step3Device = device;
            manualDeviceName.value = device.name;
            btnGrantDevicePermissions.disabled = false
            deviceStepStatus.classList.replace("bg-secondary", "bg-success");
            deviceStepStatus.classList.replace("bg-danger", "bg-success");
            deviceStepStatus.textContent = "Done"
        }).catch((error) => {
            if (error.message === "NONE") {
                return
            }
            console.error(error)
            manualDeviceName.textContent = ""
            step3Device = null
            btnGrantDevicePermissions.disabled = true
            btnEnrollDevice.disabled = true
            deviceStepStatus.textContent = "Error"
            deviceStepStatus.classList.replace("bg-secondary", "bg-danger");
            deviceStepStatus.classList.replace("bg-success", "bg-danger");
        })
    })

    $("#btn-grant-device-permissions").on("click", async function () {
        if (!step3Device) {
            console.error("Pressed device permissions without a valid device selected")
            return
        }
        step3PermissionsLock = true
        permissionStepStatus.textContent = "Accept on device"
        permissionStepStatus.classList.replace("bg-secondary", "bg-warning");
        permissionStepStatus.classList.replace("bg-danger", "bg-warning");
        permissionStepStatus.classList.replace("bg-success", "bg-warning");
        grantPermission(step3Device, 5000).then((adbObject) => {
            step3ADB = adbObject;
            permissionStepStatus.textContent = "Done"
            permissionStepStatus.classList.replace("bg-secondary", "bg-success");
            permissionStepStatus.classList.replace("bg-warning", "bg-success");
            permissionStepStatus.classList.replace("bg-error", "bg-success");
            btnEnrollDevice.disabled = false
        }).catch((error) => {
            if (step3HasDisconnected) {
                return
            }
            console.error(error)
            permissionStepStatus.textContent = "Error"
            if (error.message === "TIMEOUT") {
                permissionStepStatus.textContent = "Timeout error"
            }
            permissionStepStatus.classList.replace("bg-success", "bg-danger");
            permissionStepStatus.classList.replace("bg-secondary", "bg-danger");
            permissionStepStatus.classList.replace("bg-warning", "bg-danger");
            btnEnrollDevice.disabled = true
        }).finally(() => {
            step3PermissionsLock = false
        })
    })

    $("#btn-enroll-device").on("click", async function () {
        if (step3Provisioning) {
            return
        }
        if (!step3ADB) {
            console.error("Pressed enroll device without a valid active adb connection")
            return;
        }
        const appURL = enrollmentData['android.app.extra.PROVISIONING_DEVICE_ADMIN_PACKAGE_DOWNLOAD_LOCATION']
        const appComponentName = enrollmentData['android.app.extra.PROVISIONING_DEVICE_ADMIN_COMPONENT_NAME']
        if (!appURL || !appComponentName) {
            console.error("Tried to enroll device with corrupt enrollment data", enrollmentData)
            return;
        }
        step3Provisioning = true
        enrollStepStatus.classList.replace("bg-secondary", "bg-warning");
        enrollStepStatus.classList.replace("bg-danger", "bg-warning");
        enrollStepStatus.classList.replace("bg-success", "bg-warning");
        enrollStepStatus.textContent = "Provisioning device"
        enrollDevice(step3ADB, appURL, appComponentName).then(() => {
            enrollStepStatus.classList.replace("bg-secondary", "bg-success");
            enrollStepStatus.classList.replace("bg-danger", "bg-success");
            enrollStepStatus.classList.replace("bg-warning", "bg-success");
            enrollStepStatus.textContent = "Done"
            step3ProvisionStatus = true
        }).catch((error) => {
            enrollStepStatus.classList.replace("bg-warning", "bg-danger");
            enrollStepStatus.classList.replace("bg-secondary", "bg-danger");
            enrollStepStatus.classList.replace("bg-success", "bg-danger");
            enrollStepStatus.textContent = "Error"
            console.error(error)
            step3ProvisionStatus = false
        }).finally(() => {
            step3Provisioning = false
        })
    })

    $("#btn-step-3-next").on("click", async function () {

    })

    // STEP 4

    $("#btn-step-4-next").on("load", async function () {

    })
})

$('#smartwizard').on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex) {
    if (nextStepIndex < currentStepIndex) {
        return false;
    }
}).on('showStep', function(e, anchorObject, stepIndex) {
    if (stepIndex !== 0 && !enrollmentData) {
        $('#smartwizard').smartWizard("goToStep", 0);
    }
})

function showError(message) {
    $("#wizard-error-box").show();
    $("#step-error").text(message);
}

function cleanError() {
    $("#wizard-error-box").hide();
    $("#step-error").text('');
}

function generateQR() {
    const qrContainer = document.getElementById("qrcode");
    qrContainer.innerHTML = "";

    new QRCode(qrContainer, {
        text: JSON.stringify(enrollmentData),
        width: 400,
        height: 400,
        colorDark: "#000000",
        colorLight: "#ffffff",
        correctLevel: QRCode.CorrectLevel.H
    });
}

devicesUSBObserver.onDeviceRemove((devices) => {
    try {
        for (const device of devices) {
            if (device.name === step3Device.name) {
                console.error("The device connection was dropped")
                resetStep3()
                break
            }
        }
    } catch (error) {
        console.error("The device connection was dropped")
        resetStep3()
    }
});

function resetStep3() {

    // TODO CHANGE WITH BETTER DIALOG
    alert("The device connection was lost")

    const manualDeviceName = document.getElementById("manual-device-name")
    const grantPermissionsButton = document.getElementById("btn-grant-device-permissions")
    const enrollDeviceButton = document.getElementById("btn-enroll-device")

    manualDeviceName.textContent = "";
    grantPermissionsButton.disabled = true
    enrollDeviceButton.disabled = true
    step3Device = null
    step3HasDisconnected = true
    step3ProvisionStatus = false

    $('#device-step-status')
        .removeClass('bg-success').removeClass('bg-danger')
        .addClass('bg-secondary').text('Pending');

    $('#permission-step-status')
        .removeClass('bg-success').removeClass('bg-danger')
        .addClass('bg-secondary').text('Pending');

    $('#enroll-step-status')
        .removeClass('bg-success').removeClass('bg-danger')
        .addClass('bg-secondary').text('Pending');
}