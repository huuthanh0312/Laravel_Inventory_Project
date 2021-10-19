let login = require('./components/auth/login.vue').default
let register = require('./components/auth/register.vue').default;
let forget = require('./components/auth/forget.vue').default;
let logout = require('./components/auth/logout.vue').default;
let home = require('./components/home.vue').default;

// Employee Component
let employee = require('./components/employee/index.vue').default;
let store_employee = require('./components/employee/create.vue').default;
let edit_employee = require('./components/employee/edit.vue').default;

// Supplier Component
let supplier = require('./components/supplier/index.vue').default;
let store_supplier = require('./components/supplier/create.vue').default;
let edit_supplier = require('./components/supplier/edit.vue').default;

// Category Component
let category = require('./components/category/index.vue').default;
let store_category = require('./components/category/create.vue').default;
let edit_category = require('./components/category/edit.vue').default;

// Product Component
let product = require('./components/product/index.vue').default;
let store_product = require('./components/product/create.vue').default;
let edit_product = require('./components/product/edit.vue').default;

// Expense Component
let expense = require('./components/expense/index.vue').default;
let store_expense = require('./components/expense/create.vue').default;
let edit_expense = require('./components/expense/edit.vue').default;

// Salary Component
let add_salary = require('./components/salary/all_employee.vue').default;
let pay_salary = require('./components/salary/create.vue').default;
let salary = require('./components/salary/index.vue').default;
let view_salary = require('./components/salary/view.vue').default;
let edit_salary = require('./components/salary/edit.vue').default;

// Product Stock Component
let stock = require('./components/product/stock.vue').default;
let edit_stock = require('./components/product/edit_stock.vue').default;

// Customer Component
let customer = require('./components/customer/index.vue').default;
let store_customer = require('./components/customer/create.vue').default;
let edit_customer = require('./components/customer/edit.vue').default;

//Post Component
let pos = require('./components/pos/point_of_sale.vue').default;

//Order Component
let order = require('./components/order/order.vue').default;
let view_order = require('./components/order/view_order.vue').default;
let search_order = require('./components/order/search_order.vue').default;


export const routes = [
    { path: '/', component: login, name: '/' },
    //Auth routes
    { path: '/register', component: register, name: 'register'},
    { path: '/forget', component: forget, name: 'forget'},
    { path: '/logout', component: logout, name: 'logout'},
    { path: '/home', component: home, name: 'home'},

    // Employee Routes
    { path: '/employee', component: employee, name: 'employee'},
    { path: '/store-employee', component: store_employee, name: 'store-employee'},
    { path: '/edit-employee/:id', component: edit_employee, name: 'edit-employee'},
    

    // Supplier Routes
    { path: '/supplier', component: supplier, name: 'supplier'},
    { path: '/store-supplier', component: store_supplier, name: 'store-supplier'},
    { path: '/edit-supplier/:id', component: edit_supplier, name: 'edit-supplier'},

    // Category Routes
    { path: '/category', component: category, name: 'category'},
    { path: '/store-category', component: store_category, name: 'store-category'},
    { path: '/edit-category/:id', component: edit_category, name: 'edit-category'},
    
    // Product Routes
    { path: '/product', component: product, name: 'product'},
    { path: '/store-product', component: store_product, name: 'store-product'},
    { path: '/edit-product/:id', component: edit_product, name: 'edit-product'},

    // Expense Routes
    { path: '/expense', component: expense, name: 'expense'},
    { path: '/store-expense', component: store_expense, name: 'store-expense'},
    { path: '/edit-expense/:id', component: edit_expense, name: 'edit-expense'},

     // Salary Routes
    { path: '/given-salary', component: add_salary, name: 'given-salary'},
    { path: '/pay-salary/:id', component: pay_salary, name: 'pay-salary'},
    { path: '/salary', component: salary, name: 'salary'},
    { path: '/view-salary/:id', component: view_salary, name: 'view-salary'},
    { path: '/edit-salary/:id', component: edit_salary, name: 'edit-salary'},

    // Stock Routes
    { path: '/stock', component: stock, name: 'stock'},
    { path: '/edit-stock/:id', component: edit_stock, name: 'edit-stock'},

    // Employee Routes
    { path: '/customer', component: customer, name: 'customer'},
    { path: '/store-customer', component: store_customer, name: 'store-customer'},
    { path: '/edit-customer/:id', component: edit_customer, name: 'edit-customer'},
    
    //Pos Routes
    { path: '/pos', component: pos, name: 'pos'},

    //Order Routes
    { path: '/order', component: order, name: 'order'},
    { path: '/view-order/:id', component: view_order, name: 'view-order'},
    { path: '/search-order', component: search_order, name: 'search-order'},

  ]