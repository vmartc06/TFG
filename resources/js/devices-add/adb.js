import {Adb, AdbDaemonTransport} from "@yume-chan/adb";
import {AdbDaemonWebUsbDeviceManager} from "@yume-chan/adb-daemon-webusb";
import AdbWebCredentialStore from "@yume-chan/adb-credential-web";
import {PackageManager} from "@yume-chan/android-bin";

function checkUSBSupport() {
    return AdbDaemonWebUsbDeviceManager.BROWSER
}

async function selectUSBDevice() {
    const webUSBManager = AdbDaemonWebUsbDeviceManager.BROWSER;
    const device = await webUSBManager.requestDevice({ filters: []})
    if (!device) {
        throw new Error("NONE");
    }
    return device
}

async function grantPermission(device, timeout) {
    const connection = await device.connect();

    const CredentialStore = new AdbWebCredentialStore("TestApp");

    const transport = await Promise.race([
        AdbDaemonTransport.authenticate({
            serial: device.serial,
            connection: connection,
            credentialStore: CredentialStore,
        }),
        new Promise((_, reject) =>
            setTimeout(() => reject(new Error("TIMEOUT")), timeout)
        )
    ]);

    return new Adb(transport);
}

async function runCommand(adb, command) {
    const process = await adb.subprocess.noneProtocol.spawn(command);
    let out = ""
    const decoder = new TextDecoder();

    await process.output.pipeTo(
        new WritableStream({
            write(chunk) {
                out += decoder.decode(chunk, { stream: true });
            },
        }),
    );

    return out;
}

async function appExists(adb, appPackageName) {
    const out = await runCommand(adb, "pm list packages")

    const packages = out.split('\n')
    for (const packageName of packages) {
        if (packageName.replace("package:", "") === appPackageName) {
            return true
        }
    }

    return false
}

async function downloadApp(appURL) {
    const response = await fetch(appURL);

    if (!response.ok || !response.body) {
        throw new Error(`Failed to download APK: ${response.statusText}`);
    }

    const [streamForInstall, streamForSize] = response.body.tee();

    const sizePromise = (async () => {
        const reader = streamForSize.getReader();
        let size = 0;

        while (true) {
            const { done, value } = await reader.read();
            if (done) break;
            size += value.length;
        }

        return size;
    })();

    return {
        stream: streamForInstall,
        sizePromise
    };
}


async function enrollDevice(adb, appURL, appComponentName) {
    const { stream, sizePromise } = await downloadApp(appURL);

    const pm = new PackageManager(adb);
    await pm.installStream(await sizePromise, stream);

    const appPackageName = appComponentName.replace("/.DeviceOwnerReceiver", "");

    if (await appExists(adb, appPackageName)) {
        return
    }

    throw new Error("Managment app not installed")
}

window.checkUSBSupport = checkUSBSupport;
window.selectUSBDevice = selectUSBDevice;
window.grantPermission = grantPermission;
window.enrollDevice = enrollDevice;


