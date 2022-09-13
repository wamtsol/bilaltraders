angular.module('dashboard', ['ngAnimate', 'angularMoment', 'ui.bootstrap', 'angularjs-datetime-picker', 'ui.mask']).controller('dashboardController', 
	function ($scope, $http, $interval, $filter) {
		$scope.categories = [];
		$scope.orders = [];
		$scope.customers = [];
		$scope.suppliers = [];
		$scope.expenses = [];
		$scope.orders_return = [];
		$scope.transactions = [];
		$scope.customer_payments = [];
		$scope.supplier_payments = [];
		$scope.errors = [];
		$scope.processing = false;
		$scope.user_input = {};
		$scope.new_expense = {
			"details": "",
			"amount": "",
			"account_id": "",
			"expense_category_id": ""
		};
		$scope.new_transaction = {
			"account_id": "",
			"reference_id": "",
			"amount": "",
			"details": ""
		};
		$scope.new_customer_payment = {
			"supplier_id": "",
			"amount": "",
			"account_id": "",
			"details": ""
		};
		$scope.new_supplier_payment = {
			"supplier_id": "",
			"amount": "",
			"account_id": "",
			"details": ""
		};
		$scope.accounts =[]; 
		angular.copy($scope.accounts);
		$scope.petty_cash = {};
		$scope.expense_categories = [];
		$scope.wctAJAX = function( wctData, wctCallback ) {
			wctRequest = {
				method: 'POST',
				url: 'index.php',
				headers: {'Content-Type': 'application/x-www-form-urlencoded'},
				transformRequest: function(obj) {
					var str = [];
					for(var p in obj){
						str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
					}
					return str.join("&");
				},
				data: wctData
			}
			$http(wctRequest).then(function(wctResponse){
				wctCallback(wctResponse.data);
			}, function () {
				console.log("Error in fetching data");
			});
		}
		$scope.wctAJAX( {action: 'get_customers'}, function( response ){
			$scope.customers = response;
		});
		$scope.wctAJAX( {action: 'get_suppliers'}, function( response ){
			$scope.suppliers = response;
		});
		$scope.wctAJAX( {action: 'get_orders'}, function( response ){
			$scope.orders = response;
		});
		$scope.wctAJAX( {action: 'get_orders_return'}, function( response ){
			$scope.orders_return = response;
		});
		$scope.wctAJAX( {action: 'get_expense'}, function( response ){
			$scope.expenses = response;
		});
		$scope.wctAJAX( {action: 'get_customer_payment'}, function( response ){
			$scope.customer_payments = response;
		});
		$scope.wctAJAX( {action: 'get_supplier_payment'}, function( response ){
			$scope.supplier_payments = response;
		});
		
		$scope.wctAJAX( {action: 'get_accounts'}, function( response ){
			$scope.accounts = response;
			for( i = 0; i < $scope.accounts.length; i++ ) {
				if( $scope.accounts[ i ].is_petty_cash == 1 ) {
					$scope.petty_cash = $scope.accounts[ i ];
					break;
				}
			
			}
		});
		$scope.wctAJAX( {action: 'get_expense_category'}, function( response ){
			$scope.expense_categories = response;
		});
		$scope.wctAJAX( {action: 'get_transaction'}, function( response ){
			$scope.transactions = response;
		});
		$scope.add_expense = function(){
			if( $scope.processing == false ) {
				if( $scope.new_expense.expense_category_id == "" || $scope.new_expense.account_id == "" || $scope.new_expense.amount <= 0 ){
					alert("Enter Expense Category, Account and Amount.");
				}
				else{
					$scope.processing = true;
					$scope.wctAJAX( {action: 'add_expense', expense: JSON.stringify($scope.new_expense)}, function( response ){
						$scope.processing = false;
						if( response.status == 1 ) {
							$scope.new_expense = {
								"details": "",
								"amount": 0,
								"account_id": "",
								"expense_category_id": ""
							};
							$scope.expenses.unshift(response.expense);
						}
						else{
							alert(response.message);
						}
					});	
				}
			}
		}
		$scope.expense_total = function( type ) {
			total = 0;
			for( i = 0; i < $scope.expenses.length; i++ ) {
				if( typeof type === 'undefined' || ( type == 0 && $scope.expenses[ i ].account_id == $scope.petty_cash.id ) || ( type != 0 && $scope.expenses[ i ].account_id != $scope.petty_cash.id ) ) {
					total += parseFloat($scope.expenses[ i ].amount);
				}
			}
			return total;
		}
		$scope.add_customer_payment = function(){
			if( $scope.processing == false ) {
				if( $scope.new_customer_payment.customer_id == "" || $scope.new_customer_payment.account_id == "" || $scope.new_customer_payment.amount <= 0 ){
					alert("Enter Customer, Account and Amount.");
				}
				else{
					$scope.processing = true;
					$scope.wctAJAX( {action: 'add_customer_payment', customer_payment: JSON.stringify($scope.new_customer_payment)}, function( response ){
						$scope.processing = false;
						if( response.status == 1 ) {
							$scope.new_customer_payment = {
								"customer_id": "",
								"amount": "",
								"account_id": "",
								"details": ""
							};
							$scope.customer_payments.unshift(response.customer_payment);
						}
						else{
							alert(response.message);
						}
					});	
				}
			}
		}
		$scope.customer_payment_total = function(type) {
			total = 0;
			for( i = 0; i < $scope.customer_payments.length; i++ ) {
				if( typeof type === 'undefined' || ( type == 0 && $scope.customer_payments[ i ].account_id == $scope.petty_cash.id ) || ( type != 0 && $scope.customer_payments[ i ].account_id != $scope.petty_cash.id ) ) {
					total += parseFloat($scope.customer_payments[ i ].amount);
				}
			}
			return total;
		}
		$scope.add_supplier_payment = function(){
			if( $scope.processing == false ) {
				if( $scope.new_supplier_payment.supplier_id == "" || $scope.new_supplier_payment.account_id == "" || $scope.new_supplier_payment.amount <= 0 ){
					alert("Enter Supplier, Account and Amount.");
				}
				else{
					$scope.processing = true;
					$scope.wctAJAX( {action: 'add_supplier_payment', supplier_payment: JSON.stringify($scope.new_supplier_payment)}, function( response ){
						$scope.processing = false;
						if( response.status == 1 ) {
							$scope.new_supplier_payment = {
								"supplier_id": "",
								"amount": "",
								"account_id": "",
								"details": ""
							};
							$scope.supplier_payments.unshift(response.supplier_payment);
						}
						else{
							alert(response.message);
						}
					});	
				}
			}
		}
		$scope.supplier_payment_total = function(type) {
			total = 0;
			for( i = 0; i < $scope.supplier_payments.length; i++ ) {
				if( typeof type === 'undefined' || ( type == 0 && $scope.supplier_payments[ i ].account_id == $scope.petty_cash.id ) || ( type != 0 && $scope.supplier_payments[ i ].account_id != $scope.petty_cash.id ) ) {
					total += parseFloat($scope.supplier_payments[ i ].amount);
				}
			}
			return total;
		}
		$scope.add_transaction = function(){
			if( $scope.processing == false ) {
				$scope.new_transaction.amount=parseFloat($scope.new_transaction.amount);
				if( $scope.new_transaction.account_id == "" || $scope.new_transaction.reference_id == "" ||  $scope.new_transaction.amount<= 0 ){
					alert("Select Accounts and Amount.");
				}
				else{
					$scope.processing = true;
					$scope.wctAJAX( {action: 'add_transaction', transaction: JSON.stringify($scope.new_transaction)}, function( response ){
						$scope.processing = false;
						if( response.status == 1 ) {
							$scope.new_transaction = {
								"account_id": "",
								"reference_id": "",
								"amount": "",
								"details": ""								
							};
							$scope.transactions.unshift(response.transaction);
						}
						else{
							alert(response.message);
						}
					});	
				}
			}
		}
		$scope.transaction_total = function(account_id, balance) {
			total = balance;
			for( i = 0; i < $scope.transactions.length; i++ ) {
				if( $scope.transactions[ i ].account_id == account_id ) {
					total -= parseFloat($scope.transactions[ i ].amount);
				}
				if( $scope.transactions[ i ].reference_id == account_id ) {
					total += parseFloat($scope.transactions[ i ].amount);
				}
			}
			return total;
		}
		$scope.order_total_items = function( order ) {
			total = 0;
			for( i = 0; i < order.items.length; i++ ) {
				total += order.items[ i ].quantity;
			}
			return total;
		}
		$scope.order_return_total_items = function( order_return ) {
			total = 0;
			for( i = 0; i < order_return.items.length; i++ ) {
				total += order_return.items[ i ].quantity;
			}
			return total;
		}
		$scope.order_total = function( order ) {
			total = 0;
			for( i = 0; i < order.items.length; i++ ) {
				if( typeof order.items[ i ] ) {
					total += (parseFloat(order.items[ i ].sale_price) * parseFloat(order.items[ i ].quantity));
				}
			}
			if( typeof order.discount !== "undefined" ){
				total -= parseFloat(order.discount);
			}
			return total;
		}
		$scope.order_return_total = function( order_return ) {
			total = 0;
			for( i = 0; i < order_return.items.length; i++ ) {
				if( typeof order_return.items[ i ] ) {
					total += (parseFloat(order_return.items[ i ].sale_price) * parseFloat(order_return.items[ i ].quantity));
				}
			}
			if( typeof order_return.discount !== "undefined" ){
				total -= parseFloat(order_return.discount);
			}
			return total;
		}
		$scope.orders_total_items = function( orders ) {
			total = 0;
			for( i = 0; i < orders.length; i++ ) {
				for( j = 0; j < orders[i].items.length; j++ ) {
					total += orders[ i ].items[ j ].quantity;
				}
			}
			return total;
		}
		$scope.orders_return_total_items = function( orders_return ) {
			total = 0;
			for( i = 0; i < orders_return.length; i++ ) {
				for( j = 0; j < orders_return[i].items.length; j++ ) {
					total += orders_return[ i ].items[ j ].quantity;
				}
			}
			return total;
		}
		$scope.orders_total = function( orders, type ) {
			
			total = 0;
			for( i = 0; i < orders.length; i++ ) {
				if( typeof type === 'undefined' || ( type == 0 && orders[ i ].account_id == "0" ) || ( type != 0 && orders[ i ].account_id != "0" ) ) {
					for( j = 0; j < orders[i].items.length; j++ ) {
						
							total += (parseFloat(orders[ i ].items[ j ].sale_price) * parseFloat(orders[ i ].items[ j ].quantity));
					}
					if( typeof orders[ i ].discount !== "undefined" ){
						total -= parseFloat(orders[ i ].discount);
					}
				}
			}
			return total;
		}
		$scope.orders_return_total = function( orders_return, type ) {
			
			total = 0;
			for( i = 0; i < orders_return.length; i++ ) {
				if( typeof type === 'undefined' || ( type == 0 && orders_return[ i ].account_id == "0" ) || ( type != 0 && orders[ i ].account_id != "0" ) ) {
					for( j = 0; j < orders_return[i].items.length; j++ ) {
						
							total += (parseFloat(orders_return[ i ].items[ j ].sale_price) * parseFloat(orders_return[ i ].items[ j ].quantity));
					}
					if( typeof orders_return[ i ].discount !== "undefined" ){
						total -= parseFloat(orders_return[ i ].discount);
					}
				}
			}
			return total;
		}
		$scope.cash_in_hand = function(){
			
			var total = $scope.transaction_total( $scope.petty_cash.id, $scope.petty_cash.balance );
			total += $scope.orders_total($scope.orders, 0);
			total += $scope.customer_payment_total(0);
			total -= $scope.supplier_payment_total(0);
			total -= $scope.expense_total(0);
			total -= $scope.orders_return_total($scope.orders_return, 0);
			return total;
			
		}
		$scope.print_receipt = function( id ) {
			$("<iframe>")
				.hide()
				.attr("src", "index.php?tab=print_receipt&id="+id)
				.appendTo("body"); 
		}	
	}
).directive('ngEnter', function() {
        return function(scope, element, attrs) {
            element.bind("keydown keypress", function(event) {
                if(event.which === 13) {
                    scope.$apply(function(){
                        scope.$eval(attrs.ngEnter, {'event': event});
                    });

                    event.preventDefault();
                }
            });
        };
    });