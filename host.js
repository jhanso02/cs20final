var http = require('http');
var fs = require('fs');
var qs = require('querystring');

const express = require('express');
const app = express();
const bodyParser = require('body-parser');
app.set('view engine','ejs');

const MongoClient = require('mongodb').MongoClient;
const url = "mongodb+srv://Harnaljia:Harnaljia@band.huo1y.mongodb.net/Band?retryWrites=true&w=majority";

//const popup = require('node-popup/dist/cjs.js');
//import * as popup from 'node-popup/src/index.ts';
//const popup = require('node-popup');  

app.listen(3000,function(){
    console.log('listening on 3000');
});

app.use(bodyParser.urlencoded({extended: true})); 

// app.post('/info',function(req,res){
//     //console.log("In progress");

//     MongoClient.connect(url, { useUnifiedTopology: true }, function(err, db) {
//         if(err) { return console.log(err); return;}
//         var dbo = db.db("Info");
//         var collection = dbo.collection('schedule');
//         //TO DO: process the data 
//         processData(req,collection);
//         console.log("After function");
//         populate(collection);
//         console.log("after filling in info")
//         //db.close();
//     });
    
//     console.log("Done");
// });

MongoClient.connect(url, { useUnifiedTopology: true }, function(err, db) {
    if(err) { return console.log(err); return;}
    var dbo = db.db("Info");
    var collection = dbo.collection('schedule');

    app.get('/',function(req,res){
        console.log("in get");
        populate(collection,res);
        //res.sendFile('/Users/harnaljia/desktop/Final' + '/scheduleView.html');
       
    });
    
    app.post('/process',function(req,res){ //telling server what to do when it gets to where we want it to be. 
        console.log("opening form");
        res.sendFile('/Users/harnaljia/desktop/Final' + '/scheduleForm.html');
    });

    app.post('/info',function(req,res){
        console.log("Processing the Data");
        // process the data 
        processData(req,collection);
        console.log("After function");

        //TDO: GOTTA GO back to the original page
        //res.render('index.ejs', {}); 
    });
});

async function processData(req,collection){
    try{
        console.log("Processing the inputed data:");
        week = ["Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday","Sunday"];
        let keys = Object.keys(req.body);

        var monday = [];
        var tuesday = [];
        var  wednesday = [];
        var thursday = [];
        var  friday = [];
        var saturday = [];
        var sunday  = [];

        mon = req.body[keys[0]];
        tues = req.body[keys[1]];
        wed = req.body[keys[2]];
        thurs = req.body[keys[3]];
        fri = req.body[keys[4]];
        sat = req.body[keys[5]];
        sun = req.body[keys[6]];

        x = mon.toString();
        mon = x.split(",");

        x = tues.toString();
        tues = x.split(",");

        x = wed.toString();
        wed = x.split(",");

        x = thurs.toString();
        thurs = x.split(",");

        x = fri.toString();
        fri = x.split(",");

        x = sat.toString();
        sat = x.split(",");

        x = sun.toString();
        sun = x.split(",");

        // Clear database to stop overlap
        collection.deleteMany({});

        for(i=0; i<mon.length; i++){
            var newData = {"Day": week[0], "Class": mon[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        }
        for(i=0; i<tues.length; i++){
            var newData = {"Day": week[1], "Class": tues[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        }
        for(i=0; i<wed.length; i++){
            var newData = {"Day": week[2], "Class": wed[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        }
        for(i=0; i<thurs.length; i++){
            var newData = {"Day": week[3], "Class": thurs[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        }
        for(i=0; i<fri.length; i++){
            var newData = {"Day": week[4], "Class": fri[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        }
        for(i=0; i<sat.length; i++){
            var newData = {"Day": week[5], "Class": sat[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        }
        for(i=0; i<sun.length; i++){
            var newData = {"Day": week[6], "Class": sun[i]};
            console.log(newData);
            var ans = collection.insertOne(newData);
        } 
        console.log("Success");
    }catch(err){
        console.log(err);
    }
}

async function populate(collection,res){
    week = ["Sunday", "Monday","Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
    try{
        // for(i=0;i<week.length;i++){
        //     console.log(week[i]);
        // }
        collection.find({"Day": "Monday"}).toArray(function(err,results){
            if (err) {
                console.log("Error: " + err);
            } 
            else {
                console.log("hellooooooo");
                // TODO: TRICKY CAUSE I DONT KNOW WHERE MONDAY WILL BE
                res.render('index.ejs', { label1: results}); 
                res.end();
            }
        });
    }catch(err){
        console.log(err);
    }
}

//     console.log("attempting alert");
//     //popup.alert("hello");
//     //send in pop up that then closes 


// //TODO: stop repeating loading 
// app.post('/info', function(req,res){
//     console.log("hfwfwf");

// app.get('/',function(req,res){
//     //returns all the information and is put into arrays
//     const cursor = collection.find().toArray().then(result => {
//         console.log(result)
//         res.redirect('/')
//     })
//     .catch(error => console.error(error));
// })

//db.close();

