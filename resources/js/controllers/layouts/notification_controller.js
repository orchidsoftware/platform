import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     * @type {*[]}
     */
    static targets = ["badge"];

    /**
     *
     */
    initialize() {
        const count = this.data.get('count');

        localStorage.setItem('profile.notifications', count);

        window.addEventListener('storage', this.storageChanged());
    }

    /**
     *
     */
    connect() {
        this.render();
    }

    /**
     *
     */
    disconnect() {
        window.removeEventListener('storage', this.storageChanged());
    }

    /**
     *
     * @returns {string}
     */
    storageKey() {
        return 'profile.notifications';
    }

    /**
     *
     * @returns {Function}
     */
    storageChanged() {
        return (event) => {
            if (event.key === this.storageKey()) {
                this.render();
            }
        }
    }

    /**
     *
     */
    render() {
        const count = localStorage.getItem('profile.notifications');

        let badge = '<i class="icon-circle"></i>';

        if (count < 10) {
            badge = count;
        }

        if(count === null || parseInt(count) === 0){
            badge = '';
        }

        this.badgeTarget.innerHTML = badge;
    }


    noticeFavicon(bool) {
        const favicon = document.getElementById('favicon');

        const img = document.createElement('img');
        img.src = favicon.href;
        const lineWidth = 2;
        const canvas = document.createElement('canvas');

        img.onload = () => {
            canvas.width = img.width;
            canvas.height = img.height;

            const context = canvas.getContext('2d');

            context.clearRect(0, 0, img.width, img.height);
            context.drawImage(img, 0, 0);

            const centerX = img.width - (img.width / 5) - lineWidth;
            const centerY = img.height - (img.height / 5) - lineWidth;
            const radius = img.width / 5;

            context.fillStyle = '#dc3545';
            context.strokeStyle = '#ffffff';
            context.lineWidth = lineWidth;
            context.beginPath();
            context.arc(centerX, centerY, radius, 0, Math.PI * 2, false);
            context.closePath();
            context.fill();
            context.stroke();

            // Replace favicon
            favicon.href = canvas.toDataURL('image/png');
        }
    }

}
