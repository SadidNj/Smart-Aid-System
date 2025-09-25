document.addEventListener('DOMContentLoaded', function(){
    const checkBtn = document.getElementById('checkBtn');
    const aqText = document.getElementById('aqText');

    function showNotification(title, body) {
        if (!('Notification' in window)) return;
        if (Notification.permission === 'granted') {
            new Notification(title, { body });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') new Notification(title, { body });
            });
        }
    }

    async function checkAQ(lat, lon) {
        aqText.textContent = 'Checking...';
        try {
            const res = await fetch(`../controller/fetchAQ.php?lat=${encodeURIComponent(lat)}&lon=${encodeURIComponent(lon)}`);
            const data = await res.json();

            if (data.error) {
                aqText.textContent = 'Error: ' + data.error;
                return;
            }

            const map = {1:'Good',2:'Fair',3:'Moderate',4:'Poor',5:'Very Poor'};
            const aqi = data.aqi;

            aqText.innerHTML = `<strong>AQI:</strong> ${aqi} (${map[aqi]||'Unknown'})`;

            // Alert for bad AQI
            if (aqi >= 4) {
                showNotification('Air Quality Alert', `AQI ${aqi} - ${map[aqi]}. Take precautions.`);
                aqText.innerHTML += '<br><span style="color:red; font-weight:bold;">ALERT: Unhealthy air quality!</span>';
            }

        } catch(e) {
            aqText.textContent = 'Fetch error: ' + e.message;
        }
    }

    checkBtn.addEventListener('click', function(){
        const lat = document.getElementById('lat').value;
        const lon = document.getElementById('lon').value;
        if (!lat || !lon) { alert('Please enter latitude and longitude'); return; }
        checkAQ(lat, lon);
    });

    // Auto-check every 60s
    setInterval(function(){
        const lat = document.getElementById('lat').value;
        const lon = document.getElementById('lon').value;
        if (lat && lon) checkAQ(lat, lon);
    }, 60000);
});
