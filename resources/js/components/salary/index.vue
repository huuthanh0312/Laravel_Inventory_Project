<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/given-salary" class="btn btn-rounded btn-primary">Add Salary</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">All Salary Details</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <select class="form-control" id="exampleFormControlSelect1" v-model="searchItem">
                                        <option value="" disabled selected>Select Salary By Year</option>
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
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Month Name</th>
                                        <th>Details</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="salary in filterSearch" :key="salary.id">
                                        <td>{{salary.salary_month}}</td>
                                        <td>
                                            <router-link :to="{name: 'view-salary', params:{id:salary.salary_month}}" class="btn btn-sm btn-primary">
                                                View Salary</router-link>
                                            
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
                return salary.salary_month.match(this.searchItem)
            })
        }
    },
    methods: {
        allSalary() {
            axios.get('/api/salary')
                .then(({data}) => this.salaries = data)
                .catch()
        }
    },
    created() {
        this.allSalary();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>