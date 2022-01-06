<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1. Data Nasabah</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <p class="h1 my-5">Customer Data</p>

        <div class="row mb-3">
            <div class="col-12">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary float-end btn-modal-trigger" data-bs-toggle="modal"
                    data-bs-target="#nasabahModal">
                    Add Customer
                </button>
            </div>
        </div>
        <table id="main-table" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Account ID</th>
                    <th>Name</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <p class="h1 text-center no-data d-none">No Data Available</p>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="nasabahModal" tabindex="-1" aria-labelledby="nasabahModalLabel" aria-hidden="true"
        data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <form class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nasabahModalLabel">Add Customer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="Name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" aria-describedby="name">
                        <small class="text-danger error-text error-name d-none">Name must be filled</small>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" aria-describedby="address">
                        <small class="text-danger error-text error-address d-none">Address must be filled</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary btn-submit">Save changes</button>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script>
    $(document).ready(function() {
        let baseurl = "http://localhost:8000/"

        // trigger modal
        $(".btn-modal-trigger").on("click", function() {
            $("#name").val("")
            $("#address").val("")
            $(".error-text").addClass("d-none")
        })

        // klik submit
        $(".btn-submit").on("click", function() {
            let name = $("#name").val()
            let address = $("#address").val()

            if (name == "") {
                $(".error-name").removeClass("d-none")
                return false
            } else {
                $(".error-name").addClass("d-none")
            }

            if (address == "") {
                $(".error-address").removeClass("d-none")
                return false
            } else {
                $(".error-address").addClass("d-none")
            }

            $.ajax({
                url: baseurl + "nasabah",
                method: "post",
                dataType: "json",
                data: {
                    name: name,
                    address: address
                },
                error: function(err) {
                    console.log(err)
                },
                success: function(res) {
                    console.log(res)
                    updateTable()
                    $("#nasabahModal").modal("hide")
                }
            })
        })



        function updateTable() {
            $.ajax({
                url: baseurl + "nasabah",
                type: "get",
                dataType: "json",
                error: function(err) {
                    console.log("error")
                    console.log(err)
                },
                success: function(res) {
                    let result = ""

                    if (res.length == 0) {
                        $(".no-data").removeClass("d-none")
                    } else {
                        $(".no-data").addClass("d-none")
                    }

                    $.each(res, function(key, val) {
                        console.log(val)
                        result += `
                        <tr>
                            <td>` + (key + 1) + `</td>
                            <td>` + val.account_id + `</td>
                            <td>` + val.name + `</td>
                            <td>` + val.address + `</td>
                        </tr>
                        `
                    })
                    $("#main-table tbody").html(result)
                }
            })
        }
        updateTable()
    });
    </script>
</body>

</html>