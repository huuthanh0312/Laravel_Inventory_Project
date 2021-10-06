<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Add Expense</h1>
                            </div>
                            <div class="float-right">
                                <router-link to="/expense" class="btn btn-rounded btn-primary">All Expense</router-link>
                            </div>
                            <br><br>
                            <hr>  
                            <form @submit.prevent="expenseInsert">
                                <div class="row">
                                    <div class="form-group col-sm-12" >
                                        <label for="details">Expense Detail</label>
                                        <textarea class="form-control" id="details" cols="10" rows="5" v-model="form.details"></textarea> 
                                        <small class="text-danger" v-if="errors.details">{{ errors.details[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-12" >
                                        <label for="amount">Expense Amount</label>
                                        <input type="text" class="form-control" id="amount" placeholder="Enter amount" v-model="form.amount">
                                        <small class="text-danger" v-if="errors.amount">{{ errors.amount[0]}}</small>
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
                details: null,     
                amount: null,
           },
           errors:{}
       } 
    },
    methods: {
        expenseInsert(){
            
            axios.post('/api/expense', this.form)
            .then(() => {
                this.$router.push({name: 'expense'})
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