<template>
    <div class="container">
        <div class="card" style="margin-top: 20px;">
            <div class="card-body">
                <form @submit.prevent="submit">
                    <div class="form-group">
                        <label for="name">Pick Color</label>
                        <input type="color" class="form-control" name="color" id="color" v-model="fields.color" />
                        <div v-if="errors && errors.color" class="text-danger">{{ errors.color[0] }}</div>
                    </div>
                    
                    <div class="form-group">
                        <label for="logo">Logo</label>
                        <input type="file" class="form-control" ref="logo" name="logo" id="logo" @change="previewFiles"/>
                        <div id="preview">
                            <img v-if="url" :src="url" width="150" height="150" style="margin-top: 10px;" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="heading_text">Heading Text</label>
                        <input type="text" class="form-control" name="heading_text" id="heading_text" v-model="fields.heading_text" required />
                        <div v-if="errors && errors.heading_text" class="text-danger">{{ errors.heading_text[0] }}</div>
                    </div>

                    <div class="form-group">
                        <label for="website_url">Website URL</label>
                        <input type="text" class="form-control" name="website_url" id="website_url" v-model="fields.website_url" />
                        <div v-if="errors && errors.website_url" class="text-danger">{{ errors.website_url[0] }}</div>
                    </div>

                    <div class="form-group">
                        <label for="facebook_url">Facebook URL</label>
                        <input type="text" class="form-control" name="facebook_url" id="facebook_url" v-model="fields.facebook_url" />
                        <div v-if="errors && errors.facebook_url" class="text-danger">{{ errors.facebook_url[0] }}</div>
                    </div>

                    <button type="submit" class="btn btn-primary" style="margin-top: 20px;">Search Image</button>
                </form>
                <div v-for="image in images">
                    <img v-if="image" :src="image.urls.full" width="150" height="150" style="margin-top: 10px;" />
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import 'vue-swatches/dist/vue-swatches.css'    
    export default {
        data() {
            return {
                fields: {},
                errors: {},
                color: '#1CA085',
                images: [],
                logo: null,
                url: null
            }
          },
          methods: {
            submit() {
                this.errors = {};
                if (this.fields.heading_text) {
                    axios.post('/search', this.fields).then(response => {
                        this.images = response.data.images
                    }).catch(error => {
                        if (error.response.status === 422) {
                            this.errors = error.response.data.errors || {};
                        }
                    });
                }
            },
            previewFiles() {
                this.file = this.$refs.logo.files[0]
                this.url = URL.createObjectURL(this.file);
            },
        },
    }
</script>
<style>

</style>