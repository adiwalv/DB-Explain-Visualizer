 var vt;

 window.onload = function () {
     var container = document.getElementById("container");

     vt = new VTree(container);
     var reader = new VTree.reader.Object();
     function readTextFile(file) {
         var allText;
         var rawFile = new XMLHttpRequest();
         rawFile.open("GET", file, false);
         rawFile.onreadystatechange = function ()
         {
             if(rawFile.readyState === 4)
             {
                 if(rawFile.status === 200 || rawFile.status == 0)
                 {
                     allText = rawFile.responseText;
                 }
             }
         }
         rawFile.send(null);
         return allText;
     }

     function updateTree() {
         var obj = readTextFile("uploads/temp.json");
         obj = JSON.parse(obj);
         var s = JSON.stringify(obj.executionStats.executionStages);


         try {
             var jsonData = JSON.parse(s);
         } catch (e) {

         }

         var data = reader.read(jsonData);

         vt.data(data)
           .update();
     }

     function showFullTree() {
         var s = readTextFile("uploads/temp.json");
         try {
             var jsonData = JSON.parse(s);
         } catch (e) {

         }

         var data = reader.read(jsonData);

         vt.data(data)
             .update();
     }
     document.getElementById("go-button").onclick = showFullTree;
     updateTree();
 };
