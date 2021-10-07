<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/salary" class="btn btn-rounded btn-primary">All Salary</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Employee List</h1>
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
                                        <th>Photo</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Salary</th>
                                        <th>Joining Date</th>
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="employee in filterSearch" :key="employee.id">
                                        <td>{{employee.name}}</td>
                                        <td><img :src="employee.photo" alt="" id="em_photo"></td>
                                        <td>{{employee.phone}}</td>
                                        <td>{{employee.address}}</td>
                                        <td>{{employee.salary}} $</td>
                                        <td>{{employee.joining_date}}</td>
                                        <td>
                                            <router-link :to="{name: 'pay-salary', params:{id:employee.id}}" class="btn btn-sm btn-success">
                                                Pay Salary</router-link>
                                
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
           employees:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.employees.filter(employee => {
                return employee.name.match(this.searchItem)
            })
        }
    },
    methods: {
        allEmployee() {
            axios.get('/api/employee')
                .then(({data}) => this.employees = data)
                .catch()
        },
        deleteEmployee(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/employee/' + id)
                .then(() => {
                    this.employees = this.employees.filter( employee => {
                        return employee.id != id
                    })
                })
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
        })
    }
    },
    created() {
        this.allEmployee();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>