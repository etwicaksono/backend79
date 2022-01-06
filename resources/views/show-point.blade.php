<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3. Show Customer Point</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link href="https://unpkg.com/gijgo@1.9.13/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

</head>

<body>
    <div class="container">
        <p class="h1 my-5">Show Customer Point</p>

        <table id="main-table" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Account ID</th>
                    <th>Name</th>
                    <th>Total Point</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>

        <p class="h1 text-center no-data d-none">No Data Available</p>
    </div>

    </div>


    <script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>


    <script>
    $(document).ready(function() {
        let baseurl = "http://localhost:8000/"

        $.ajax({
            url: baseurl + "cek-poin",
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
                        <td>` + val.point + `</td>
                    </tr>
                    `
                })
                $("#main-table tbody").html(result)
            }
        })
    });
    </script>
</body>

</html>