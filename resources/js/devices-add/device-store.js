export async function registerDevice() {

    const deviceName = $("#device-name").val();
    if (!deviceName) {
        throw new Error("Please enter a device name before proceeding.");
    }

    const response = await fetch(apiAddDevicesRoute, {
        method: 'POST',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
        },
        body: JSON.stringify({
            name: deviceName
        })
    });

    const responseText = await response.text();
    const responseJSON = JSON.parse(responseText);

    if (response.status === 422) {
        if (responseJSON.errors.name) {
            throw new Error("The name is already in use")
        }
        throw new Error("Unknown error, try again");
    }

    if (!response.ok) {
        throw new Error("Unexpected error occurred")
    }

    return { responseJSON, deviceName }
}

export async function checkEnrollment(deviceName) {
    const url = new URL(apiDevicesRoute);
    url.searchParams.append('enrolled', '1');

    const response = await fetch(url.toString(), {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'Authorization': 'Bearer ' + token,
        }
    });

    const responseText = await response.text();
    const responseJSON = JSON.parse(responseText);

    if (!response.ok) {
        throw new Error("Unexpected error occurred")
    }

    return responseJSON.some(
        (device) => device.name === deviceName
    )
}

window.registerDevice = registerDevice;
window.checkEnrollment = checkEnrollment;