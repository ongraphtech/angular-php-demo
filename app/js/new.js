
/* Main controller area */

function MainCtrl($scope, $http) {
    $scope.errors = [];
    $scope.msgs = [];

    $scope.Login = function() {

        $scope.errors.splice(0, $scope.errors.length); // remove all error messages
        $scope.msgs.splice(0, $scope.msgs.length);

        if($scope.username == undefined) //cross-check for dirty value
            return;
        if($scope.userpassword == undefined) //cross-check for dirty value
            return;

        $http.post('backend/getData.php', {'uname': $scope.username, 'pswd': $scope.userpassword}
        ).success(function(data, status, headers, config) {
            if (data.message != '') {
                $scope.msgs.push(data.message);
            }
            else {
                $scope.errors.push(data.error);
            }
        }).error(function(data, status) { // called asynchronously if an error occurs
            // or server returns response with an error status.
            $scope.errors.push(status);
        });
    }
}
