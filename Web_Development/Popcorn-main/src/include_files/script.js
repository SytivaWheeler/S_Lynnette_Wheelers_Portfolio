fetch('https://imdb-api.com/en/API/MostPopularMovies/k_rg8j0aoo').then((data)=>{
    return data.json();
}).then((completedata)=>{
    //console.log(completedata.items);
    let data1="";
    let data2="";
    completedata.items.map((values)=>{
        data1+=`   <div class = "card" style="width: 18rem;">
		<img class="card-img-top" src=${values.image} alt = "img">
		<div class="card-body">
        	<h1 class = "titles">${values.title}</h1>
			<form action="../include_files/insert_list.php" method="POST">
			<button type="submit" class= "btn btn-primary" name="favbtn" value="${values.id}"> Favorite</button>
            <button type="submit" class= "btn btn-primary" name="watchbtn" value="${values.id}"> Watch List</button>
			</form>
		</div>
		
    </div>`

        data2+=`<div class = "poster">
            <h1 class = "titles">${values.title}</h1>
            <img src=${values.image} alt="img" class="images">
			
        </div>
    </div>`
    });
    document.getElementById("movies").innerHTML=data1
    //document.getElementById("movie_card").innerHTML=data2
}).catch((err)=>{
    console.log(err);
})