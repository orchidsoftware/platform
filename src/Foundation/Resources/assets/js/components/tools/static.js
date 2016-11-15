if (document.querySelector('#static-container')) {
    new Vue({
        el: '#static-container',
        data: {
            query: '',
            active: {},
            routes: [],
            baseUrl: '',
            activeBase: '',
        },
        ready: function () {
            this.$http.get('/dashboard/static?json=true').then(function (response) {
                this.$set('routes', response.data.routes);
                this.$set('baseUrl', response.data.baseUrl);
                console.log(this);
            });
        },
        methods: {
            show: function (index) {
                this.activeBase = index;
                this.$http.get('/dashboard/static/' + index).then(function (response) {
                    if (response.data) {
                        this.$set('active', response.data);
                    }
                    $('#static-modal').modal("show");
                });
            },
            update: function () {
                this.$http.put('/dashboard/static/' + this.activeBase, this.active).then(function (response) {
                    console.log(response);
                    $('#static-modal').modal("hide");
                });
            }

        }
    });
}