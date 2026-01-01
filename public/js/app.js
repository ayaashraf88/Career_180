// // This MUST run before Alpine.js core loads
// document.addEventListener('alpine:init', () => {
//     Alpine.store('theme', {
//         on: false, // or your $persist logic
//         toggle() {
//             this.on = !this.on;
//             console.log('Theme is now:', this.on);
//         }
//     });
// });