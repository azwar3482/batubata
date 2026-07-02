import { driver } from 'driver.js';
import 'driver.js/dist/driver.css';

window.driver = driver;

window.createTour = function(steps, extraConfig) {
    return driver({
        showProgress: true,
        nextBtnText: 'Lanjut ➔',
        prevBtnText: '⬅ Kembali',
        doneBtnText: 'Selesai',
        popoverClass: 'driverjs-theme',
        allowClose: true,
        overlayClickNext: false,
        ...extraConfig,
        steps: steps
    });
};
