import $ from 'jquery';

interface IFieldInformation {
    label: string;
    type: string;
    model: string;
    default?: string;
    note?: string;
    hint?: string;
    warning?: string;
}

const customElementTextarea: vuejs.ComponentOption = {
    template: `<div class="cc-input cc-input--type-textarea">
        <label for="{{fieldConfiguration.model | prefixFieldId}}" class="cc-input__label" v-if="fieldConfiguration.label">
            {{fieldConfiguration.label | translate}}:
        </label>
        <textarea class="cc-input__textarea" id="{{fieldConfiguration.model | prefixFieldId}}" :name="fieldConfiguration.model" v-model="configuration[fieldConfiguration.model] | prettify"></textarea>
        <p class="cc-warning" v-if="fieldConfiguration.warning">{{{fieldConfiguration.warning | translate}}}</p>
        <p class="cc-input__note" v-if="fieldConfiguration.note">{{{fieldConfiguration.note | translate}}}</p>
        <p class="cc-input__hint" v-if="fieldConfiguration.hint">{{{fieldConfiguration.hint | translate}}}</p>
    </div>`,

    props: {
        fieldConfiguration: {
            type: Object,
            default(): any {
                return {};
            },
        },

        configuration: {
            type: Object,
            default(): any {
                return {};
            },
        },

        teaserIndex: {
            type: Number,
            default: 0,
        },
    },

    filters: {
        translate(txt: string): string {
            return $.mage.__(txt);
        },

        prefixFieldId(id: string): string {
            return `cfg-teaser-${this.teaserIndex}-${id}`;
        },

        prettify: {
            read(txt: string): string {
                return (txt ? txt.replace(/<br\s*[\/]?>/gi, '\n') : '');
            },

            write(txt: string): any {
                return txt.replace(/\n/g, '<br>');
            },
        },
    },

    ready(): void {
        /**
         * Set default value if model is not set yet and default value is defined in etc/view.xml
         */
        if (
            this.configuration[this.fieldConfiguration.model] == null &&
            this.fieldConfiguration.default != null
        ) {
            this.$set(`configuration.${this.fieldConfiguration.model}`, this.fieldConfiguration.default);
        }
    },
};

export default customElementTextarea;
