<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Update Salary</h1>
                            </div>
                            
                            <br><br>
                            <hr>  
                            <form @submit.prevent="salaryUpdate">
                                <div class="row">
                                    <div class="form-group col-sm-6" >
                                        <label for="name">Employee Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Your Full Name" v-model="form.name">
                                        <small class="text-danger" v-if="errors.name">{{ errors.name[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="email">Employee Email</label>
                                        <input type="email" class="form-control" id="email" aria-describedby="emailHelp"
                                        placeholder="Enter Your Email" v-model="form.email">
                                        <small class="text-danger" v-if="errors.email">{{ errors.email[0]}}</small>
                                    </div>
                                  <div class="form-group col-sm-6">
                                        <label for="exampleFormControlSelect1">Month</label>
                                        <select class="form-control" id="exampleFormControlSelect1" v-model="form.salary_month">
                                            <option value="January">January</option>
                                            <option value="February">February</option>
                                            <option value="March">March</option>
                                            <option value="April">April</option>
                                            <option value="May">May</option>
                                            <option value="June">June</option>
                                            <option value="July">July</option>
                                            <option value="August">August</option>
                                            <option value="September">September</option>
                                            <option value="October">October</option>
                                            <option value="November">November</option>
                                            <option value="December">December</option>
                                    
                                        </select>
                                        <small class="text-danger" v-if="errors.salary_month">{{ errors.salary_month[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="salary">Salary</label>
                                        <input type="text" class="form-control" id="salary" aria-describedby="emailHelp"
                                        placeholder="Enter Your Salary" v-model="form.amount">
                                        <small class="text-danger" v-if="errors.amount">{{ errors.amount[0]}}</small>
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
         <div class="float-left">
            <router-link to="/salary" class="btn btn-rounded btn-primary">Go Back</router-link>
        </div> 
        <br>
        <br>
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
                amount: '',
                salary_month: '',
           },
           errors:{}
       } 
    },
    created() {
        let id  = this.$route.params.id
        axios.get('/api/salary/edit/' + id)
        .then(({data}) => (this.form = data) )
        .catch(Notification.error)
    },
    methods: {
        salaryUpdate(){
            let id  = this.$route.params.id
            axios.post('/api/salary/update/'+id, this.form)
            .then(() => {
                this.$router.push({name: 'salary'})
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