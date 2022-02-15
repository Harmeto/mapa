//callback a express
const { response } = require('express');
const express = require('express');
const app = express();
//Base de datos
const Datastore = require('nedb');
//app escuchando puerto 3000 
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => console.log(`listening on port'${PORT}`));
app.use(express.static('public'));
app.use(express.json({ limit: '1mb' }));

const database = new Datastore('database.db');
database.loadDatabase();

//consigue los datos de /api
app.get('/api', (request, response) => {
    database.find({}, (err, data) => {
        if (err) {
            response.end();
            return;
        }
        response.json(data);
    });

});


//recibe los datos de index.html 
app.post('/api', (request, response) => {
    const data = request.body;
    const timestamp = Date.now();
    data.timestamp = timestamp;
    database.insert(data);
    response.json(data);
    console.log('recibido');
});