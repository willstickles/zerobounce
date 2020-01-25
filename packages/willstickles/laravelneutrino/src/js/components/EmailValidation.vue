<template>
    <div>
        <section v-if="errored">
            <p>We'er sorry, we're not able to retrieve the information at the moment. Please try back later</p>
        </section>

        <section v-else>
            <div v-if="loading">Loading...</div>
        </section>
        
        <div v-if="! loading">
            <form @submit.prevent="submit">
                <input type="hidden" name="_token" :value="csrf">
                <div class="form-group">
                    <label for="exampleInputEmail1">Email address</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email to validate">
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
            fields: {},
            errors: {},
            info: null,
            loading: false,
            errored: false,
            csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        }
    },
    methods: {
        submit() {
            this.loading = true
            this.errors = {};
            axios
            .get('https://api.zerobounce.net/v2/validate?api_key=a870019d9b8f4297bafd5cec33f859e6&email=will.stickles.sensei@gmail.com&ip_address=')
            .then( response => {
                this.info = response.data
                console.log('success');
                console.log(this.info)
            })
            .catch( error => {
                console.log('error')
                console.log(error)
                this.errored = true
            })
            .finally( () => this.loading = false )
        }

    }
}
</script>

<style>

</style>