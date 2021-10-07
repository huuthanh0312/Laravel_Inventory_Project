<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Employee Salary Details</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <input type="text" class="form-control" placeholder="Search Employee Here" v-model="searchItem">
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Month</th>
                                        <th>Amount</th>
                                        <th>Date</th>
   
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="salary in filterSearch" :key="salary.id">
                                        <td>{{salary.name}}</td>
                                        <td>{{salary.salary_month}}</td>
                                        <td>{{salary.amount}} $</td>
                                        <td>{{salary.salary_date}} </td>                           
                                        <td>
                                            <router-link :to="{name: 'edit-salary', params:{id:salary.id}}" class="btn btn-sm btn-primary">
                                                Edit Salary</router-link>
                                
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
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
           salaries:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.salaries.filter(salary => {
                return salary.name.match(this.searchItem)
            })
        }
    },
    methods: {
        viewSalary() {
            let id  = this.$route.params.id
            axios.get('/api/salary/view/' + id)
                .then(({data}) => this.salaries = data)
                .catch(error =>{
                this.errors = error.response.data.errors
                Notification.error()
            })
        }
    },
    created() {
        this.viewSalary();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>