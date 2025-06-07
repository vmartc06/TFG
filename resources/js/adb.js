import { AdbDaemonWebUsbDeviceManager } from "@yume-chan/adb-daemon-webusb"

async function listDevices() {
    try {
        const Manager = AdbDaemonWebUsbDeviceManager.BROWSER;

        if (!Manager) {
            console.error("The browser does not support WebUSB")
        }

        const device = await navigator.usb.requestDevice({
            filters: []
        })
    } catch (e) {
        console.error("Could not list ADB devices", e);
    }
}