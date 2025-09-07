document.addEventListener('DOMContentLoaded', function(){
    const checkBtn = document.getElementById('checkBtn');
    const aqText = document.getElementById('aqText');

    function showNotification(title, body) {
        if (!('Notification' in window)) return;
        if (Notification.permission === 'granted') {
            new Notification(title, { body: body });
        } else if (Notification.permission !== 'denied') {
            Notification.requestPermission().then(function(permission){
                if (permission === 'granted') new Notification(title, { body: body });
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
            const aqi = data.aqi;
            const map = {1:'Good',2:'Fair',3:'Moderate',4:'Poor',5:'Very Poor'};
            aqText.innerHTML = `<strong>AQI:</strong> ${aqi} (${map[aqi]||'Unknown'})`;

            // Simple alert thresholds: 4 or 5 -> notify
            if (aqi >= 4) {
                showNotification('Air Quality Alert', `AQI ${aqi} - ${map[aqi]}. Take precautions.`);
                aqText.innerHTML += '<br><span style="color:red; font-weight:bold;">ALERT: Unhealthy air quality!</span>';
            }
        } catch (e) {
            aqText.textContent = 'Fetch error: ' + e.message;
        }
    }

    checkBtn.addEventListener('click', function(){
        const lat = document.getElementById('lat').value;
        const lon = document.getElementById('lon').value;
        if (!lat || !lon) { alert('Please enter lat and lon'); return; }
        checkAQ(lat, lon);
    });

    // Auto-check every 60 seconds (for the chosen lat/lon)
    setInterval(function(){
        const lat = document.getElementById('lat').value;
        const lon = document.getElementById('lon').value;
        if (lat && lon) checkAQ(lat, lon);
    }, 60000);
});