import CustomElement from '@enhance/custom-element'

export class SuperSlider extends CustomElement {
    connectedCallback() {
        let targetEl = document.querySelector(this.getAttribute("target"))
        let unit = this.getAttribute("unit")
        let slider = this.querySelector('input[type="range"]');
        let label = this.querySelector('label')
        let readout = this.querySelector('span')
        let resetter = this.querySelector('button')

        slider.addEventListener("input", (e) => {
            targetEl.style.setProperty("font-size", slider.value + unit);
            readout.textContent = slider.value + unit;
        });

        let reset = slider.getAttribute("value");
        resetter.setAttribute("title", reset + unit);
        resetter.addEventListener("click", (e) => {
            slider.value = reset;
            slider.dispatchEvent(
                new MouseEvent("input", { view: window, bubbles: false })
            );
        });
        readout.textContent = slider.value + unit
        if (!label.getAttribute("for") && slider.getAttribute("id")) {
            label.setAttribute("for", slider.getAttribute("id"));
        }
        if (label.getAttribute("for") && !slider.getAttribute("id")) {
            slider.setAttribute("id", label.getAttribute("for"));
        }
        if (!label.getAttribute("for") && !slider.getAttribute("id")) {
            let connector = label.textContent.replace(" ", "_");
            label.setAttribute("for", connector);
            slider.setAttribute("id", connector);
        }
    }

    render({ html, state }) {
        const { attrs = {} } = state
        const { unit = '' } = attrs
        return html`
        <style>
          :host {
            display: flex;
            align-items: center;
            margin-block: 1em;
          }
          :host input[type="range"] {
            margin-inline: 0.25em 1px;
          }
          :host .readout {
            width: 3em;
            margin-inline: 0.25em;
            padding-inline: 0.5em;
            border: 1px solid #0003;
            background: #EEE;
            font: 1em monospace;
            text-align: center;
          }
        </style>
        <slot name="label"></slot>
        <span class="readout">${unit}</span>
        <slot name="input"></slot>
        <button title="${unit}">↺</button>
      `
    }
}

customElements.define('super-slider', SuperSlider)
