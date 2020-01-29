<template>
    <div>
        <section v-if="errored">
            <p>We're sorry, we're not able to retrieve the information at the moment. Please try back later</p>
        </section>

        <section v-else>
            <div v-if="loading">Loading...</div>
        </section>
        
        <div v-if="showform">
            <form @submit.prevent="submit" method="get">

                <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input type="email" v-model="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email to validate">
                    <div v-if="this.errors.email" class="alert alert-danger">{{ this.errors.email }}</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div v-if="success">

            <div>
                Email Address: {{this.infolist.address}}
            </div>

            <div>
               Status: {{this.infolist.status}}
            </div>

            <div>
               Sub Status: {{this.infolist.sub_status}}
            </div>

            <div>
               Free Email: {{this.infolist.free_email}}
            </div>

            <div>
               Did You Mean: {{this.infolist.did_you_mean}}
            </div>

            <div>
               Account Name: {{this.infolist.account}}
            </div>

            <div>
               Domain Name: {{this.infolist.domain}}
            </div>

            <div>
               Domain Age: {{this.infolist.domain_age_days}}
            </div>

            <div>
               SMTP Provider: {{this.infolist.smtp_provider}}
            </div>

            <div>
               MX Found: {{this.infolist.mx_found}}
            </div>

            <div>
               MX Record: {{this.infolist.mx_record}}
            </div>

            <div>
               First Name: {{this.infolist.firstname}}
            </div>

            <div>
               Last Name: {{this.infolist.lastname}}
            </div>

            <div>
               Gender: {{this.infolist.gender}}
            </div>

            <div>
               Country: {{this.infolist.country}}
            </div>

            <div>
               Region: {{this.infolist.region}}
            </div>

            <div>
               City: {{this.infolist.city}}
            </div>

            <div>
               Zip code: {{this.infolist.zipcode}}
            </div>

            <div>
               Process Date: {{this.infolist.processed_at}}
            </div>

        </div>

    </div>
</template>

<script>
export default {
    data() {
        return {
            errors: {},
            email: '',
            infolist: null,
            loading: false,
            errored: false,
            showform: true,
            success: false
        }
    },
    methods: {
        validateForm: function (e) {
            if ( this.email ) {
                // return true;
                this.loading = true;
                this.showform = false;
                this.success = false;
                this.errors = {};



                // var apiUrl = 'https://api.zerobounce.net/v2/validate?api_key='+process.env.MIX_ZEROBOUNCE_API_KEY;

                // fetch(apiUrl + '&email=' +  encodeURIComponent(this.email) + '&ip_address=')
                // .then(res => res.json())
                // .then( data => 
                // {
                //     this.infolist = data;
                // })
                // .catch(error => { this.errored = true })
                // .finally( () => {
                //     this.loading = false,
                //     this.success = true
                // } )                      
            }
            this.errors = [];

            if ( !this.email ) { 
                this.errors.push('Email required');
            }
            
            e.preventDefault();
        },

        submit() {
                this.loading = true;
                this.showform = false;
                this.success = false;
            this.errors = {};

            let fields = {
                email: this.email
            }

            axios.post('validate_emails', fields)
            .then(response => {
                this.infolist = response.data;
                this.success = true;
            })
            .catch( error => {
                this.showform = true;
                // this.errored = true
                console.log("error" + error);
                if ( error.response.status === 422) {
                    this.errors = error.response.data.errors || {};
                    console.log('this error: ' + this.errors.email);
                }
            })
            .finally( () => {
                this.loading = false;
                
            });
        }
    }
}
</script>

<style>

</style>