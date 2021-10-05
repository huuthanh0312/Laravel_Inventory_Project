<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Add Supplier</h1>
                            </div>
                            <div class="float-right">
                                <router-link to="/supplier" class="btn btn-rounded btn-primary">All Supplier</router-link>
                            </div>
                            <br><br>
                            <hr>  
                            <form @submit.prevent="supplierInsert" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-sm-6" >
                                        <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Your Full Name" v-model="form.name">
                                        <small class="text-danger" v-if="errors.name">{{ errors.name[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="email" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Email" v-model="form.email">
                                        <small class="text-danger" v-if="errors.email">{{ errors.email[0]}}</small>
                                    </div>
                                    
                                    <div class="form-group col-sm-6" >
                                        <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Your Address" v-model="form.address">
                                        <small class="text-danger" v-if="errors.address">{{ errors.address[0]}}</small>
                                    </div>
                                    
                                    <div class="form-group col-sm-6">
                                        <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Shop Name" v-model="form.shopname">
                                        <small class="text-danger" v-if="errors.shopname">{{ errors.shopname[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Phone Number" v-model="form.phone">
                                        <small class="text-danger" v-if="errors.phone">{{ errors.phone[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <small class="text-danger" v-if="errors.photo">{{ errors.photo[0]}}</small>
                                        </div>                                      
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <img :src="form.photo" class="float-right" style="width: 50px; height:50px;">                                   
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
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
                name: null,
                email: null,
                phone: null,
                address: null,
                photo: null,
                shopname: null,
           },
           errors:{}
       } 
    },
    methods: {
        onFileSelected(event){
            let file = event.target.files[0];
            if(file.size > 5242880){
                Notification.image_validation()
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.photo = event.target.result
    
                };
                reader.readAsDataURL(file);
            }
        },
        supplierInsert(){
            
            axios.post('/api/supplier', this.form)
            .then(() => {
                this.$router.push({name: 'supplier'})
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