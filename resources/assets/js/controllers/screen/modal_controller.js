import {Controller} from "stimulus";

export default class extends Controller {

    /**
     *
     * @type {string[]}
     */
    static targets = [
        "title"
    ];

    /**
     *
     * @param options
     */
    open(options) {
        this.titleTarget.textContent = options.title;
        this.element.querySelector('form').action = options.submit;
        
        if(this.data.get('async')){
            this.asyncLoadData(JSON.parse(options.params));
        }

        $(this.element).modal('toggle')
    }

    /**
     *
     * @param params
     */
    asyncLoadData(params) {
        let modal = this;
        axios.post( this.data.get('url') +'/'+ this.data.get('method') + '/' + this.data.get('slug'),params).then(function (response) {
            modal.element.querySelector('[class="async-content"]').innerHTML = response.data;
        });
    }
    
    submit (event) {
        event.preventDefault();
        const posturl = this.element.querySelector('form').action ;
        
        var formData = $(this.element.querySelector('form')).serializeObject();
        axios.post( posturl,formData).then();
        
        $(this.element).modal('toggle');
    }
    
    
}