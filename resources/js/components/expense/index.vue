<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/store-expense" class="btn btn-rounded btn-primary">Add Expense</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Expense List</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <input type="text" class="form-control" placeholder="Search Expense Here" v-model="searchItem">
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Details</th>
                                        <th>Amount</th>
                                        <th>Expense Date</th>
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="expense in filterSearch" :key="expense.id">
                                        <td>{{expense.details}}</td>
                                        <td>{{expense.amount}} $</td>
                                        <td>{{expense.expense_date}}</td>
                                        <td>
                                            <router-link :to="{name: 'edit-expense', params:{id:expense.id}}" class="btn btn-sm btn-warning">
                                                Edit</router-link>
                                            <a @click="deleteExpense(expense.id)" class="btn btn-sm btn-danger text-white">Delete</a>
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
           expenses:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.expenses.filter(expense => {
                return expense.details.match(this.searchItem)
            })
        }
    },
    methods: {
        allExpense() {
            axios.get('/api/expense')
                .then(({data}) => this.expenses = data)
                .catch()
        },
        deleteExpense(id) {
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
                axios.delete('/api/expense/' + id)
                .then(() => {
                    this.expenses = this.expenses.filter( expense => {
                        return expense.id != id
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
        this.allExpense();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>