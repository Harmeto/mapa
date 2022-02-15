<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="">
</head>

<body>
    <h1>Datos de la Base de Datos</h1>
    <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

    <script>
        getData();

        async function getData() {
            const response = await fetch('/api');
            const data = await response.json();
            //imprime datos de db en html
            for (item of data) {
                const root = document.createElement('div');
                const escr = document.createElement('div');
                const geo = document.createElement('div');
                const date = document.createElement('div');


                escr.textContent = `Fruta: ${item.escr}`;
                geo.textContent = `${item.lat}º, ${item.lon}º`;
                const dateString = new Date(item.timestamp).toLocaleString();
                date.textContent = dateString;

                root.append(escr, geo, date);
                document.body.append(root);
            }

            console.log(data);
        }
    </script>
</body>

</html>