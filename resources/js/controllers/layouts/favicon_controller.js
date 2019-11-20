import {Controller} from 'stimulus';

export default class extends Controller {

    /**
     *
     */
    initialize() {
        this.data.set('originalFavicon', this.favicon);
    }

    /**
     *
     * @param isUnreadNotice
     */
    notice(isUnreadNotice = true) {
        const img = document.createElement('img');
        img.src = this.data.get('originalFavicon');

        const lineWidth = 2;
        const canvas = document.createElement('canvas');

        img.onload = () => {
            canvas.width = img.width;
            canvas.height = img.height;

            const context = canvas.getContext('2d');

            context.clearRect(0, 0, img.width, img.height);
            context.drawImage(img, 0, 0);

            if (isUnreadNotice) {
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
            }

            // Replace favicon
            this.favicon = canvas.toDataURL('image/png');
        };
    }

    /**
     *
     * @returns {*}
     */
    get favicon() {
        return this.element.href;
    }

    /**
     *
     * @param href
     */
    set favicon(href) {
        this.element.href = href;
    }
}
