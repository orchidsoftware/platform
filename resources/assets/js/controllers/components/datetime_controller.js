import {Controller} from "stimulus"

import Flatpickr from "stimulus-flatpickr";

import rangePlugin from "flatpickr/dist/plugins/rangePlugin.js";

import "flatpickr/dist/l10n";
//import "flatpickr/dist/l10n/fr.js";
//import "flatpickr/dist/l10n/ru.js";

//import "flatpickr/dist/themes/dark.css";


export default class extends Flatpickr  {


    initialize() {
        var language;
        if (window.navigator.languages) {
            language = window.navigator.languages[0];
        } else {
            language = window.navigator.userLanguage || window.navigator.language;
        }
        
        var plugins = [];
        if (this.data.get('range')) {
            plugins.push(new rangePlugin({ input: this.data.get('range')}))
        }
        
        this.config = {
            locale: language,
            "plugins": plugins,
        };
    }
     
    
    connect() {
        super.connect();

    }
      
     
    change(selectedDates, dateStr, instance) {
        return dateStr;
    }
}