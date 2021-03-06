import $ from 'jquery';

interface IFieldInformation {
    label: string;
    type: string;
    model: string;
    checked?: boolean;
    note?: string;
    hint?: string;
    warning?: string;
}

const customElementCheckbox: vuejs.ComponentOption = {
    template: `<div class="cc-input cc-input--type-switcher">
        <div class="admin__actions-switch" data-role="switcher">
            <input type="checkbox" class="admin__actions-switch-checkbox" id="{{fieldConfiguration.model | prefixFieldId}}" :name="fieldConfiguration.model" v-model="configuration[fieldConfiguration.model]">
            <label class="admin__actions-switch-label" for="{{fieldConfiguration.model | prefixFieldId}}" v-if="fieldConfiguration.label">
                <span class="admin__actions-switch-text">{{fieldConfiguration.label | translate}}</span>
            </label>
        </div>
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
    },

    ready(): void {
        /**
         * Set default value if model is not set yet and default value is defined in etc/view.xml
         */
        if (
            this.configuration[this.fieldConfiguration.model] == null &&
            this.fieldConfiguration.checked != null
        ) {
            this.$set(`configuration.${this.fieldConfiguration.model}`, this.fieldConfiguration.checked);
        }
    }
};

export default customElementCheckbox;
