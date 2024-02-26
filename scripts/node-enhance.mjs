import { SuperSlider } from './elements/super-slider.mjs';
import MyCard from './elements/my-card.mjs';
import enhance from '@enhance/ssr'
const html = enhance({
    elements: {
        'super-slider': SuperSlider,
        'my-card': MyCard,
    }
})

let inputHtml = process.argv[2];

console.log(html`${inputHtml}`);
