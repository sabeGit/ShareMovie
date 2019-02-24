var app = new Vue({
    el: '#app',
    data: {
        keyword: '',
        items: []
    },
    methods: {
        callAPI: function() {
            axios.get('https://www.googleapis.com/books/v1/volumes?q=' + this.keyword)
            .then(response => {
                this.items = response.data.items
                console.log(this.items[0])
            })
        }
    }
})