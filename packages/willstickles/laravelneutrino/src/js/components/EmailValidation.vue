<template>
    <div>
        <section v-if="errored">
            <p>We're sorry, we're not able to retrieve the information at the moment. Please try back later</p>
        </section>

        <section v-else>
            <div v-if="loading">Loading...</div>
        </section>
        
        <div v-if="showform">
            <form @submit="validateForm" action="/submit" method="get">

                <div class="form-group">
                    <label for="inputEmail">Email address</label>
                    <input type="email" v-model="email" class="form-control" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter email to validate">
                    <div v-if="this.errors.length" class="alert alert-danger">{{ this.errors }}</div>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>

        <div v-if="success">

            <div>
                Email Address: {{infolist.address}}
            </div>

            <div>
               Status: {{infolist.status}}
            </div>

            <div>
               Sub Status: {{infolist.sub_status}}
            </div>

            <div>
               Free Email: {{infolist.free_email}}
            </div>

            <div>
               Did You Mean: {{infolist.did_you_mean}}
            </div>

            <div>
               Account Name: {{infolist.account}}
            </div>

            <div>
               Domain Name: {{infolist.domain}}
            </div>

            <div>
               Domain Age: {{infolist.domain_age_days}}
            </div>

            <div>
               SMTP Provider: {{infolist.smtp_provider}}
            </div>

            <div>
               MX Found: {{infolist.mx_found}}
            </div>

            <div>
               MX Record: {{infolist.mx_record}}
            </div>

            <div>
               First Name: {{infolist.firstname}}
            </div>

            <div>
               Last Name: {{infolist.lastname}}
            </div>

            <div>
               Gender: {{infolist.gender}}
            </div>

            <div>
               Country: {{infolist.country}}
            </div>

            <div>
               Region: {{infolist.region}}
            </div>

            <div>
               City: {{infolist.city}}
            </div>

            <div>
               Zip code: {{infolist.zipcode}}
            </div>

            <div>
               Process Date: {{infolist.processed_at}}
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

                var apiUrl = 'https://api.zerobounce.net/v2/validate?api_key='+process.env.MIX_NEUTRINO_API_KEY;
                var url = 'https://api.zerobounce.net/v2/validate';

                fetch(apiUrl + '&email=' +  encodeURIComponent(this.email) + '&ip_address=')
                .then(res => res.json())
                .then( data => 
                {
                    this.infolist = data;
                })
                .catch(error => { this.errored = true })
                .finally( () => {
                    this.loading = false,
                    this.success = true
                } )                      
            }
            this.errors = [];

            if ( !this.email ) { 
                this.errors.push('Email required');
            }
            
            e.preventDefault();
        }
    }
}
</script>

<style>

</style>