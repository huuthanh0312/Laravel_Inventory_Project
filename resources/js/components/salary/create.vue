<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Pay Salary Employee</h1>
                            </div>
                            <div class="float-right">
                                <router-link to="/given-salary" class="btn btn-rounded btn-primary">All Salary Employee</router-link>
                            </div>
                            <br><br>
                            <hr>  
                            <form @submit.prevent="salaryPaid">
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
                                        placeholder="Enter Your Salary" v-model="form.salary">
                                        <small class="text-danger" v-if="errors.salary">{{ errors.salary[0]}}</small>
                                    </div>
                                    
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">PayNow</button>
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
                salary_month: '',
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
        salaryPaid(){
            let id  = this.$route.params.id
            axios.post('/api/salary/paid/'+id, this.form)
            .then(() => {
                this.$router.push({name: 'given-salary'})
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