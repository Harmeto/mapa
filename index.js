//callback a express
import express from 'express'
const app = express();
//Base de datos
import Datastore from 'nedb'

//app escuchando puerto 3000 
const PORT = process.env.PORT || 3000;

app.use(express.static('public'));
app.use(express.json({ limit: '1mb' }));

const database = new Datastore('database.db');
database.loadDatabase();


app.get('/', (req, res)=>{
    res.render('index.html');
})

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

//route all in case url doenst exist
app.all('*', (req, res)=>{
    res.json({message: 'Not Found'})
})


app.listen(PORT, () => console.log(`listening on port'${PORT}`));