async function getIP() {
    try {
        const response = await fetch('https://api64.ipify.org?format=json');
        const data = await response.json();
        return data.ip;
    } catch (error) {
        console.error('Error fetching IP address:', error);
        return null;
    }
}

async function getUserLocationData() {
    try {
        const ip = await getIP();
        if (!ip) return null;  // Fix condition

        const response = await fetch(`https://ipapi.co/${ip}/json/`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error('Error fetching user location data:', error);
        return null;
    }
}



// Fetch and log user location data
getUserLocationData().then(data => {
    // console.log("User Location Data:", data);
    // document.getElementById("user-country").innerText = data.country_name;
    return data;
});

// Display IP in HTML element
getIP().then(ip => {
    console.log("User IP:", ip);
    document.getElementById("user-ip").innerText = ip;
});
