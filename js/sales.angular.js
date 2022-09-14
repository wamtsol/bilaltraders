angular.module('sales', ['ngAnimate', 'angularMoment', 'ui.bootstrap', 'angularjs-datetime-picker', 'ui.mask']).controller('salesController', 
	function ($scope, $http, $interval, $filter) {
		$scope.customers = [];
		$scope.errors = [];
		$scope.processing = false;
		$scope.sales_id = 0;
		$scope.categories=[];
		$scope.items=[];
		$scope.item_id = '';
		$scope.customer = {
			id: "",
			name: "",
			phone: "",
			address: "",
		};
		$scope.purchase_items = [];
		$scope.sales = {
			id: 0,
			datetime_added: '',
			customer_id: '0',
			customer: angular.copy($scope.customer),
			items: [],
			quantity: 0,
			total: 0,
			discount: 0,
			net_total: 0
		};
		$scope.item = {
			"id": "",
			"purchase_item_id":"",
			"sale_price": "",
			"discount": 0,
			"quantity": 0,
			"total": 0
		};
		$scope.updateDate = function(){
			$scope.sales.datetime_added = $(".angular-datetimepicker").val();
			$scope.$apply();
		}
		angular.element(document).ready(function () {
			$scope.wctAJAX( {action: 'get_customers'}, function( response ){
				$scope.customers = response;
			});
			$scope.wctAJAX( {action: 'get_items'}, function( response ){
				$scope.items = response;
			});
			$scope.wctAJAX( {action: 'get_categories'}, function( response ){
				$scope.categories = response;
			});
			$scope.wctAJAX( {action: 'get_purchase_items', id: $scope.sales_id}, function( response ){
				$scope.purchase_items = response;
			});
			if( $scope.sales_id > 0 ) {
				$scope.wctAJAX( {action: 'get_sales', id: $scope.sales_id}, function( response ){
					$scope.sales = response;
				});
			}
			else {
				$scope.wctAJAX( {action: 'get_datetime'}, function( response ){
					$scope.sales.datetime_added = JSON.parse( response );
				});
				$scope.sales.items.push( angular.copy( $scope.item ) );
			}
		});
		
		$scope.get_action = function(){
			if( $scope.sales_id > 0 ) {
				return 'Edit';
			}
			else {
				return 'Add New';
			}
		}
		
		$scope.add = function( position ){
			$scope.sales.items.splice(position+1, 0, angular.copy( $scope.item ) );
			$scope.update_grand_total();
		}
		
		$scope.remove = function( position ){
			if( $scope.sales.items.length > 1 ){
				$scope.sales.items.splice( position, 1 );
			}
			else {
				$scope.sales.items = [];
				$scope.sales.items.push( angular.copy( $scope.item ) );
			}
			$scope.update_grand_total();
		}
		$scope.addItemM = function( e ) {
			if( e.which == 13 && $scope.item_id != '' ) {
				$scope.addItem( $scope.item_id, 1 );
			}
		}
		$scope.addItem = function( item_id, qty ){
			item_id = ""+parseInt( item_id );
			if( $scope.sales.items.length == 1 && $scope.sales.items[ 0 ].purchase_item_id == '' ) {
				$scope.sales.items[ 0 ].purchase_item_id = item_id;
				$scope.sales.items[ 0 ].quantity = 1;
				$scope.update_sale_item( 0 );
			}
			else{
				$items = $filter('filter')( $scope.sales.items, {purchase_item_id: item_id}, 1 );
				if( $items.length == 0 ) {
					$scope.sales.items.splice(0, 0, angular.copy( $scope.item ) );
					$scope.sales.items[ 0 ].purchase_item_id = item_id;
					$scope.sales.items[ 0 ].quantity = 1;
					$scope.update_sale_item( 0 );
				}
				else {
					for( var i = 0; i < $scope.sales.items.length; i++ ){
						if( $scope.sales.items[ i ].purchase_item_id == item_id ) {
							$scope.sales.items[ i ].quantity += 1;
							$scope.update_sale_item( i );
							//return;
						}
					}	
				}
			}
			$scope.$apply();
		}		
		$scope.update_total = function( position ) {
			var available = $scope.get_available_quantity( position );
			var quantity = parseFloat( $scope.sales.items[ position ].quantity?$scope.sales.items[ position ].quantity:0 );
			if( available < quantity ) {
				quantity = available;
				$scope.sales.items[ position ].quantity = available;
			}
			$scope.sales.items[ position ].total = ( parseFloat( $scope.sales.items[ position ].sale_price ) - parseFloat( $scope.sales.items[ position ].discount?$scope.sales.items[ position ].discount:0 ) ) * quantity;
			$scope.update_grand_total();
		}
        $scope.update_grand_total = function(){
			total = 0;
			quantity = 0;
			for( i = 0; i < $scope.sales.items.length; i++ ) {
				total += parseFloat( $scope.sales.items[ i ].total );
				quantity += parseFloat( $scope.sales.items[ i ].quantity?$scope.sales.items[ i ].quantity:0 );
			}
			$scope.sales.total = total;
			$scope.sales.quantity = quantity;
			$scope.update_net_total();
		}
		$scope.update_net_total = function(){
			$scope.sales.net_total = parseFloat( $scope.sales.total ) - parseFloat( $scope.sales.discount );
		}
		$scope.wctAJAX = function( wctData, wctCallback ) {
			wctData.tab = 'addedit';
			wctRequest = {
				method: 'POST',
				url: 'sales_manage.php',
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
		$scope.save_sale = function () {
            console.log($scope.sales.items);
			$scope.errors = [];
			if( $scope.processing == false ){
				$scope.processing = true;
				data = {action: 'save_sale', sales: JSON.stringify( $scope.sales )};
                console.log(data);
				$scope.wctAJAX( data, function( response ){
					$scope.processing = false;
					if( response.status == 1 ) {
						window.location.href='sales_manage.php?tab=addedit&id='+response.id;
						$("<iframe>")
								.hide()
								.attr("src", "sales_manage.php?tab=print_receipt&id="+id)
								.appendTo("body"); 
					}
					else{
						$scope.errors = response.error;
					}
				});
			}
		}
		
		$scope.print_barcode = function( id ) {
			$("<iframe>")
				.hide()
				.attr("src", "index.php?tab=print_receipt&id="+id)
				.appendTo("body"); 
		}
        $scope.update_sale_item = function(position){
            var id = $scope.sales.items[ position ].purchase_item_id
            var item = $filter('filter')($scope.purchase_items, {id: id}, true );
            if( item.length > 0 ) {
                item = item[0];
                $scope.sales.items[ position ].purchase_item_id = item.id;
                $scope.sales.items[ position ].sale_price = item.sale_price;
				$scope.update_total(position);
            }
        }
		 $scope.get_available_quantity = function( position ){
            var id = $scope.sales.items[ position ].item_id
            var item = $filter('filter')($scope.purchase_items, {id: id}, true );
            if( item.length > 0 ) {
                return item[0].quantity;
            }
			else{
				return 0;
			}
        }
		$scope.not_listed = function( id, position ){
			var sales = angular.copy( $scope.sales.items );
			sales.splice( position, 1 );
			var item = $filter('filter')(sales, {purchase_item_id: id}, true );
            return item.length == 0;
		}
		
	}
);