<template>
    <div>
        <section v-if="errored">
            <p>We're sorry, we're not able to retrieve the information at the moment. Please try back later</p>
        </section>

        <section v-else>
            <div v-if="loading">Loading...</div>
        </section>
        
        <div v-if="showform">
            <form @submit.prevent="validateForm">

                <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input type="email" v-model="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email to validate">
                    <div v-if="this.errors.length" class="alert alert-danger">{{ this.errors }}</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: {},
            email: '',
            info: null,
            loading: false,
            errored: false,
            showform: true,
        }
    },
    methods: {
        validateForm: function (e) {
            if ( this.email ) {
                // return true;
                this.loading = true;
                this.showform = false;
                this.errors = {};

                var url = 'https://api.zerobounce.net/v2/validate';
                axios.get(url, {     
                    params: {
                        api_key: 'a870019d9b8f4297bafd5cec33f859e6',
                        email: this.email,
                        ip_address: '',
                    },
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'allowed_headers': ['*'],
                        'X-CSRF-TOKEN': window.Laravel.csrfToken
                    },
                })
                .then( response => {
                    this.info = response.data
                    console.log('success');
                    console.log(this.info);
                })
                .catch( error => {
                    this.errored = true;
                })
                .finally( () => this.loading = false )
            }
            this.errors = [];

            if ( !this.email ) {
                this.errors.push('Email required');
            }

            e.preventDefault();
        },
        // submit() {
        //     // console.log(window.Laravel.csrfToken);
        //     this.loading = true;
        //     this.showform = false;
        //     this.errors = {};

        //     var url = 'https://api.zerobounce.net/v2/validate';
        //     axios
        //     .get(url, {     
        //         params: {
        //             api_key: 'a870019d9b8f4297bafd5cec33f859e6',
        //             email: this.email,
        //             ip_address: '',
        //         },
        //         headers: {
        //             'X-Requested-With': 'XMLHttpRequest',
        //             'allowed_headers': ['*'],
        //             'X-CSRF-TOKEN': window.Laravel.csrfToken
        //         },
        //         // withCredentials: true,
        //         // credentials: 'same-origin',
        //     })
        //     .then( response => {
        //         this.info = response.data
        //         console.log('success');
        //         console.log(this.info);
        //     })
        //     .catch( error => {
        //         console.log(this.email);
        //         console.log('error');
        //         console.log(error);
        //         this.errored = true;
        //     })
        //     .finally( () => this.loading = false )
        // }

    }
}
</script>

<style>

</style>