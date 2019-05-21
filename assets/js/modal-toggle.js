    $(document).ready(function() {
      var table = $('#example').DataTable();
        
        $('#example tbody').on('click', 'tr', function () {
            var data = table.row( this ).data();
            document.getElementById("mystaffname").value = ''+data[1]+'';
            document.getElementById("mystaffid").value = ''+data[0]+'';
            document.getElementById("mystaffdept").value = ''+data[3]+'';
            document.getElementById("mystaffpos").value = ''+data[2]+'';
              $('#myModal').modal('hide');
        } );
    } );

