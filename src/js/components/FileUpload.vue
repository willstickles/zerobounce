<template>
    <div>
        <div v-if="success != ''" class="alert alert-success" role="alert">File Uploaded</div>

        <form @submit="sendFile" enctype="multipart/form-data">
        <div class="form-group">
    <label for="fileUpload">Example file input</label>
    <input type="file" class="form-control-file" id="fileUpload"  v-on:change="onFileChange">
  </div>

            <button class="btn btn-success">Submit</button>

        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            success: false,
            file: ''
        }
    },
    methods: {
        onFileChange(e) {
            this.file = e.target.files[0]
        },
        sendFile(e) {
            e.preventDefault();

            let currentObj = this;

            const config = {
                headers: { 'content-type': 'multipart/form-data'}
            }

            let formData = new FormData();

            formData.append('filename', this.file);

            axios.post('uploadfile', formData, config)
            .then( function (response) {
                currentObj.success = response.data.success;
            })
            .catch( function (error) {
                current.output = error
            });
        }
    }
}
</script>

<style>

</style>