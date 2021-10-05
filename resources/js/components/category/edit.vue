<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Category Update</h1>
                            </div>
                            <div class="float-right">
                                <router-link to="/category" class="btn btn-rounded btn-primary">All Category</router-link>
                            </div>
                            <br><br>
                            <hr>  
                            <form @submit.prevent="categoryUpdate" >
                                <div class="row">
                                    <div class="form-group col-sm-12" >
                                        <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Category Name" v-model="form.category_name">
                                        <small class="text-danger" v-if="errors.category_name">{{ errors.category_name[0]}}</small>
                                    </div>
                                    
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>


<script>
export default {
    created() {
        if(!User.loggedIn()){
            this.$router.push({name: '/'})
        }
    },
    
    data() {
       return {
           form:{
                category_name: '',
           },
           errors:{}
       } 
    },
    created() {
        let id  = this.$route.params.id
        axios.get('/api/category/' + id)
        .then(({data}) => (this.form = data) )
        .catch(Notification.error)
    },
    methods: {
        categoryUpdate(){
            let id  = this.$route.params.id
            axios.patch('/api/category/'+id, this.form)
            .then(() => {
                this.$router.push({name: 'category'})
                Notification.success()
            })
            .catch(error =>{
                this.errors = error.response.data.errors
                Notification.error()
            })
            
        }
    }
}
</script>

<style scoped>

</style>