<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Employee Update</h1>
                            </div>
                            <div class="float-right">
                                <router-link to="/employee" class="btn btn-rounded btn-primary">All Employee</router-link>
                            </div>
                            <br><br>
                            <hr>  
                            <form @submit.prevent="employeeUpdate" enctype="multipart/form-data">
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
                                    <div class="form-group col-sm-12" >
                                        <input type="text" class="form-control" id="exampleInputLastName" placeholder="Enter Your Address" v-model="form.address">
                                        <small class="text-danger" v-if="errors.address">{{ errors.address[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Salary" v-model="form.salary">
                                        <small class="text-danger" v-if="errors.salary">{{ errors.salary[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="date" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Joining Date" v-model="form.joining_date">
                                        <small class="text-danger" v-if="errors.joining_date">{{ errors.joining_date[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Phone" v-model="form.phone">
                                        <small class="text-danger" v-if="errors.phone">{{ errors.phone[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <input type="text" class="form-control" id="exampleInputEmail" aria-describedby="emailHelp"
                                        placeholder="Enter Your Nid" v-model="form.nid">
                                        <small class="text-danger" v-if="errors.nid">{{ errors.nid[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <small class="text-danger" v-if="errors.newphoto">{{ errors.newphoto[0]}}</small>
                                        </div>                                      
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <img :src="form.newphoto" alt="" style="width: 50px; height:50px;">                                   
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
                name: '',
                email: '',
                address: '',
                salary: '',
                joining_date: '',
                phone: '',
                nid: '',
                photo: '',
                newphoto: '',
           },
           errors:{}
       } 
    },
    created() {
        let id  = this.$route.params.id
        axios.get('/api/employee/' + id)
        .then(({data}) => (this.form = data) )
        .catch(Notification.error)
    },
    methods: {
        onFileSelected(event){
            let file = event.target.files[0];
            if(file.size > 5242880){
                Notification.image_validation()
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.newphoto = event.target.result
                };
                reader.readAsDataURL(file);
            }
        },
        employeeUpdate(){
            let id  = this.$route.params.id
            axios.patch('/api/employee/'+id, this.form)
            .then(() => {
                this.$router.push({name: 'employee'})
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