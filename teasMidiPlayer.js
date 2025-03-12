let midiNotesArray = new Array();

let midiTimers = [];
let isPlaying = false;
let playbackSpeed = 1;
let timeOffset = 0;
let startTime = 0;
let pausedTime = 0;
let devicesnum = 0;

WebMidi.enable(function () {
}).then(function () {
    let midiDevices = document.getElementById("midiDevices")
    WebMidi.outputs.forEach(output => {
        let devices = document.createElement("option")
        devices.text = output.name + " [" + devicesnum + "]"
        devicesnum++
        devices.value = output.name
        midiDevices.add(devices, null);
    })
})
document.getElementById("playButton").addEventListener("click", function () {
    if (!isPlaying) {
        playMidi();
    }
});
function playMidi() {
    if (isPlaying) return;

    let device = document.getElementById("midiDevices").value;
    let output = WebMidi.getOutputByName(device);
    document.getElementById("playa").innerText = "播放中..."
    isPlaying = true;
    stopMidi();

    startTime = performance.now() - pausedTime;
    pausedTime = 0;
    
    midiNotesArray.forEach(n => {
        const adjustedStart = (n.startTime - timeOffset) / playbackSpeed;
        const adjustedEnd = (n.endTime - timeOffset) / playbackSpeed;
        
        if (adjustedStart < 0) return;
        
        const noteOnDelay = adjustedStart * 1000;
        const noteOffDelay = adjustedEnd * 1000;

        const onTimer = setTimeout(() => {
            output.playNote(n.pitch, 1, { velocity: n.velocity / 127 });
        }, noteOnDelay);

        const offTimer = setTimeout(() => {
            output.stopNote(n.pitch, 1);
        }, noteOffDelay);

        midiTimers.push(onTimer, offTimer);
    });
}
function stopMidi() {
    isPlaying = false;
    pausedTime = 0;
    midiTimers.forEach(timer => clearTimeout(timer));
    midiTimers = [];
}