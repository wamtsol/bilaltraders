angular.module('sales_return', ['ngAnimate', 'angularMoment', 'ui.bootstrap', 'angularjs-datetime-picker', 'ui.mask']).controller('salesreturnController', 
	function ($scope, $http, $interval, $filter) {
		$scope.customers = [];
		$scope.errors = [];
		$scope.processing = false;
		$scope.sales_return_id = 0;
		$scope.item_id = '';
		$scope.customer = {
			id: "",
			name: "",
			phone: "",
			address: "",
		};
		$scope.purchase_items = [];
		$scope.sales_return = {
			id: 0,
			datetime_added: '',
			customer_id: '',
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
			$scope.sales_return.datetime_added = $(".angular-datetimepicker").val();
			$scope.$apply();
		}
		angular.element(document).ready(function () {
			$scope.wctAJAX( {action: 'get_customers'}, function( response ){
				$scope.customers = response;
			});
			$scope.wctAJAX( {action: 'get_purchase_items', id: $scope.sales_return_id}, function( response ){
				$scope.purchase_items = response;
			});
			if( $scope.sales_return_id > 0 ) {
				$scope.wctAJAX( {action: 'get_sales_return', id: $scope.sales_return_id}, function( response ){
					$scope.sales_return = response;
				});
			}
			else {
				$scope.wctAJAX( {action: 'get_datetime'}, function( response ){
					$scope.sales_return.datetime_added = JSON.parse( response );
				});
				$scope.sales_return.items.push( angular.copy( $scope.item ) );
			}
		});
		
		$scope.get_action = function(){
			if( $scope.sales_return_id > 0 ) {
				return 'Edit';
			}
			else {
				return 'Add New';
			}
		}
		
		$scope.add = function( position ){
			$scope.sales_return.items.splice(position+1, 0, angular.copy( $scope.item ) );
			$scope.update_grand_total();
		}
		
		$scope.remove = function( position ){
			if( $scope.sales_return.items.length > 1 ){
				$scope.sales_return.items.splice( position, 1 );
			}
			else {
				$scope.sales_return.items = [];
				$scope.sales_return.items.push( angular.copy( $scope.item ) );
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
			if( $scope.sales_return.items.length == 1 && $scope.sales_return.items[ 0 ].purchase_item_id == '' ) {
				$scope.sales_return.items[ 0 ].purchase_item_id = item_id;
				$scope.sales_return.items[ 0 ].quantity = 1;
				$scope.update_sale_item( 0 );
			}
			else{
				$items = $filter('filter')( $scope.sales_return.items, {purchase_item_id: item_id}, 1 );
				if( $items.length == 0 ) {
					$scope.sales_return.items.splice(0, 0, angular.copy( $scope.item ) );
					$scope.sales_return.items[ 0 ].purchase_item_id = item_id;
					$scope.sales_return.items[ 0 ].quantity = 1;
					$scope.update_sale_item( 0 );
				}
				else {
					for( var i = 0; i < $scope.sales_return.items.length; i++ ){
						if( $scope.sales_return.items[ i ].purchase_item_id == item_id ) {
							$scope.sales_return.items[ i ].quantity += 1;
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
			var quantity = parseFloat( $scope.sales_return.items[ position ].quantity?$scope.sales_return.items[ position ].quantity:0 );
			if( available < quantity ) {
				quantity = available;
				$scope.sales_return.items[ position ].quantity = available;
			}
			$scope.sales_return.items[ position ].total = ( parseFloat( $scope.sales_return.items[ position ].sale_price ) - parseFloat( $scope.sales_return.items[ position ].discount?$scope.sales_return.items[ position ].discount:0 ) ) * quantity;
			$scope.update_grand_total();
		}
        $scope.update_grand_total = function(){
			total = 0;
			quantity = 0;
			for( i = 0; i < $scope.sales_return.items.length; i++ ) {
				total += parseFloat( $scope.sales_return.items[ i ].total );
				quantity += parseFloat( $scope.sales_return.items[ i ].quantity?$scope.sales_return.items[ i ].quantity:0 );
			}
			$scope.sales_return.total = total;
			$scope.sales_return.quantity = quantity;
			$scope.update_net_total();
		}
		$scope.update_net_total = function(){
			$scope.sales_return.net_total = parseFloat( $scope.sales_return.total ) - parseFloat( $scope.sales_return.discount );
		}
		$scope.wctAJAX = function( wctData, wctCallback ) {
			wctData.tab = 'addedit';
			wctRequest = {
				method: 'POST',
				url: 'sales_return_manage.php',
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
		$scope.save_sale_return = function () {
            console.log($scope.sales_return.items);
			$scope.errors = [];
			if( $scope.processing == false ){
				$scope.processing = true;
				data = {action: 'save_sale_return', sales_return: JSON.stringify( $scope.sales_return )};
                console.log(data);
				$scope.wctAJAX( data, function( response ){
					$scope.processing = false;
					if( response.status == 1 ) {
						window.location.href='sales_return_manage.php?tab=addedit&id='+response.id;
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
            var id = $scope.sales_return.items[ position ].purchase_item_id
            var item = $filter('filter')($scope.purchase_items, {id: id}, true );
            if( item.length > 0 ) {
                item = item[0];
                $scope.sales_return.items[ position ].purchase_item_id = item.id;
                $scope.sales_return.items[ position ].sale_price = item.sale_price;
				$scope.update_total(position);
            }
        }
		 $scope.get_available_quantity = function( position ){
            var id = $scope.sales_return.items[ position ].purchase_item_id
            var item = $filter('filter')($scope.purchase_items, {id: id}, true );
            if( item.length > 0 ) {
                return item[0].quantity;
            }
			else{
				return 0;
			}
        }
		$scope.not_listed = function( id, position ){
			var sales_return = angular.copy( $scope.sales_return.items );
			sales_return.splice( position, 1 );
			var item = $filter('filter')(sales_return, {purchase_item_id: id}, true );
            return item.length == 0;
		}
	}
);