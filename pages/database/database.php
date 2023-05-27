<!--Lists-->
<div class="w3-row w3-padding-64">
    <div class="w3-container w3-teal">
        <h1>Links in database</h1>
    </div>
    <div class="w3-container">
        <p>Hover over the "Select Channel" to select the links of a Channel. Click on "New Channel" to create a new one.</p>

        <div class="w3-bar w3-teal">
            <div class="w3-dropdown-hover">
                <button class="w3-button">Select Channel</button>
                <div class="w3-dropdown-content w3-bar-block w3-border w3-teal" id="channels">
                </div>
            </div>
            <button class="w3-button" onclick="document.getElementById('newChannelModal').style.display='block'">New Channel</button>

        </div>
    </div>
    <div class="w3-container w3-margin-top">
        <div class="w3-container w3-card-4" >
            <h2 class="w3-text-teal">Search links</h2>
            <p>Search links from database</p>
            <p>
                <label for="txtUrl" class="w3-text-teal"><b>search</b></label>
                <input class="w3-input w3-border w3-margin-bottom" type="text" name="txtsearch" id="txtsearch">
                <input class="w3-btn w3-teal" value="search" type="button" id="btnsearch" name="btnsearch">
            </p>
        </div>

    </div>
</div>


<div class="w3-row">

    <div class="w3-twothird" style="padding: 0;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0 24px;">
            <h1 class="w3-text-teal">Links</h1>
            <button id="sortButton" onclick="sortList()" class="w3-button w3-teal w3-large"><i class="fas fa-sort"></i> Sort</button>
        </div>
        <div class="w3-container">
            <ul class="w3-ul w3-card-4" id="linklist">
                <!-- List items will be appended here -->
            </ul>
        </div>
    </div>




    <div class="w3-third w3-container">
        <div class="w3-border w3-padding-large w3-padding-64 w3-center">
            <div class="w3-container w3-card-4" action="/action_page.php">
                <h2 class="w3-text-teal">Add Url Form</h2>
                <p>Add a new url using this form</p>
                <p>
                    <label for="txtUrl" class="w3-text-teal"><b>Url</b></label>
                    <input class="w3-input w3-border w3-margin-bottom" type="text" name="txtUrl" id="txtUrl">
                    <input class="w3-btn w3-teal" value="Check" type="button" id="checkUrl" name="checkUrl">
            </div>
        </div>
<!--        <div class="w3-border w3-padding-large w3-padding-32 w3-center">AD</div>-->
    </div>
</div>
<!--Lists-->

<!--row click popup-->
<div id="myModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom w3-card-4">
        <header class="w3-container w3-teal">
            <span onclick="document.getElementById('myModal').style.display='none'" class="w3-button w3-display-topright w3-large">&times;</span>
            <h2>Edit Item</h2>
        </header>
        <div class="w3-container">
            <p>Title: <input id="editTitle" class="w3-input w3-border w3-margin-top" type="text"></p>
            <p>URL: <input id="editURL" class="w3-input w3-border w3-margin-top" type="text"></p>
            <p>Thumbnail URL: <input id="editThumbURL" class="w3-input w3-border w3-margin-top" type="text"></p>
        </div>
        <footer class="w3-container w3-teal w3-padding">
            <button onclick="submitChanges()" class="w3-button w3-white w3-border w3-round">Submit</button>
        </footer>
    </div>
</div>

<!--popup-->

<!--new url popup-->
<!-- check url Modal -->
<div id="modal" class="w3-modal">
    <div class="w3-modal-content w3-animate-zoom w3-card-4">
        <header class="w3-container w3-teal">
            <span onclick="document.getElementById('modal').style.display='none'"
                  class="w3-button w3-display-topright">&times;</span>
            <h2 id="modalTitle"></h2>
        </header>
        <div class="w3-container">
            <br>
            <img id="modalImage" class="w3-image" alt="Image" style="width:50%;"/>
            <p id="modalDescription"></p>
            <p id="modalPostTime"></p>
        </div>
        <footer class="w3-container w3-teal w3-padding">
            <button id="closeModal" class="w3-button w3-white w3-border w3-round-large" onclick="closeModal()">Close</button>
            <input id="saveLink" class="w3-button w3-white w3-border w3-round-large" onclick="saveLink()" value="Save">
        </footer>
    </div>
</div>

<!--new url popup-->

<!--new Channel window-->
<div id="newChannelModal" class="w3-modal">
    <div class="w3-modal-content">
        <header class="w3-container w3-teal">
        <span onclick="document.getElementById('newChannelModal').style.display='none'"
              class="w3-button w3-display-topright">&times;</span>
            <h2>New Channel</h2>
        </header>
        <div class="w3-container w3-margin">
            <label for="channelName">Channel Name:</label>
            <input type="text" id="channelName" name="channelName" class="w3-input w3-border">
            <p id="error-message" style="color: red; display: none;">Please enter a channel name!</p>
        </div>
        <footer class="w3-container w3-teal w3-padding">
            <button class="w3-button w3-red" onclick="document.getElementById('newChannelModal').style.display='none'">Cancel</button>
            <button class="w3-button w3-green" id="create-channel">Create Channel</button>
        </footer>
    </div>
</div>
<!--new channel window-->

<script>
    document.addEventListener('readystatechange', function(evt) {
        if(evt.target.readyState == "complete")
        {
            loadList();
            loadChannels();
        }
    }, false);

    function loadList(){
        fetch('database/getvideo?format=raw')
            .then(response => response.json())
            .then(data => {
                createlist(data);
            })
    }

    function loadChannels(){
        fetch('database/loadchannels?format=raw')
            .then(response => response.json())
            .then(data => {
                createChannellist(data);
            })
    }

    function createlist(data){
        const ul = document.querySelector(".w3-ul");
        ul.innerHTML = '';
        ul.classList = "w3-ul w3-hoverable";
        data.forEach(item => {
            const li = document.createElement('li');
            li.className = "w3-bar w3-hover-teal";
            li.style.cursor = "pointer";
            li.id = item.id;
            li.innerHTML = `<span onclick="deletePost(${item.id})" class="w3-bar-item w3-button w3-white w3-xlarge w3-right">×</span>
                            <img src="${item.thumbnailUrl}" class="w3-bar-item w3-hide-small" style="width:150px">
                            <div class="w3-bar-item" id=${item.id}>
                                <span class="w3-large">${item.title.substring(0, 80)}</span><br>
                                <span>${item.regdate}</span><br>
                                <button onclick="deletePost(${item.id})" class="w3-button w3-red w3-margin-top">Delete</button>
                                <button onclick="schedulePost(${item.id})" class="w3-button w3-blue w3-margin-top">Add to Schedule</button>
                            </div>
                                    `;
            li.addEventListener('click', function() {
                document.getElementById('editTitle').value = item.title;
                document.getElementById('editURL').value = item.url;
                document.getElementById('editThumbURL').value = item.thumbnailUrl;
                document.getElementById('myModal').style.display = 'block';
            });


            ul.appendChild(li);
        });


    }

    function createChannellist(data){
        document.getElementById("channels").innerHTML ="";
        data.forEach(item => {
            document.getElementById("channels").innerHTML += `<a href="#" class="w3-bar-item w3-button" c-value="${item.id}">${item.name}</a>`;
        });


        console.log(data);
    }

    function submitChanges() {
        document.getElementById('myModal').style.display = 'none';
    }

    function deletePost(id){
        event.stopPropagation();
        if(confirm("are you sure you want to delete this post?")){
            const scheduled_id = id;
            $.ajax({
                type: "POST",
                url: "database/delete?format=raw",
                data: {
                    id: scheduled_id,
                },
                success: (response) => {
                    if(response.result == true){
                        alert("deleted successfully");
                    }else{
                        alert("problem with deletion");
                    }

                    loadList();
                },
                error: () => {
                    alert("An error occurred while scheduling the video.");
                },
            });
        }
    }

    function schedulePost(id){
        event.stopPropagation();
        const scheduled_id = id;
        $.ajax({
            type: "POST",
            url: "database/schedulepost?format=raw",
            data: {
                id: scheduled_id,
            },
            success: (response) => {
                if(response.result == true){
                    alert("link added to scheduler successfully");
                }else{
                    alert("problem with added link to scheduler");
                }

                loadList();
            },
            error: () => {
                alert("An error occurred while scheduling the video.");
            },
        });
    }


    let urlData = null;
    document.querySelector('#checkUrl').addEventListener('click', () => {
        const url = document.querySelector('#txtUrl').value;

        if(!validateUrl(url)) {
            alert("Invalid URL");
            return;
        }

        const formData = new FormData();
        formData.append('url', url);

        fetch('database/fetchurl?format=raw', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                document.querySelector('#modalTitle').innerText = data.title;
                document.querySelector('#modalDescription').innerText = data.description;
                document.querySelector('#modalImage').src = data.image;
                document.querySelector('#modalPostTime').innerText = data.postedtime ? 'Posted on: ' + data.postedtime : '';
                document.querySelector('#modal').style.display = "block";
                data.url =  url;
                urlData = data;
            });
    });

    document.querySelector('#txtsearch').addEventListener('keydown', function(event) {
        // The keyCode for the Enter key is 13
        if (event.keyCode === 13) {
            event.preventDefault();
            search();
        }
    });


    document.querySelector('#btnsearch').addEventListener('click', () => {
        search();
    });


    function search(){
        const search = document.querySelector('#txtsearch').value;

        if(search.trim()=="") {
            loadList();
            return;
        }


        fetch('database/search?format=raw', {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({ search: search})
             })
            .then(response => response.json())
            .then(data => {
                createlist(data);
            });
    }


    function closeModal() {
        document.querySelector('#modal').style.display = "none";
    }


    function validateUrl(value) {
        var url;
        try {
            url = new URL(value);
        } catch (_) {
            return false;
        }
        return url.protocol === "http:" || url.protocol === "https:";
    }

    function saveLink(){

        fetch("database/addurl?format=raw", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(urlData),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("HTTP error " + response.status);
            }
            return response.json();
        })
        .then(data => {
            if (data && data.message) {
                alert(data.message);
                loadList();
                closeModal();
            } else {
                console.error("Unexpected response data:", data);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }

    // Define your sort state outside the sort function
    let isAscending = true;

    function sortList() {
        var list, i, switching, b, shouldSwitch;
        list = document.getElementById("linklist");
        switching = true;
        while (switching) {
            switching = false;
            b = list.getElementsByClassName("w3-bar");
            for (i = 0; i < (b.length - 1); i++) {
                shouldSwitch = false;
                if (isAscending) {
                    if (b[i].innerText.toLowerCase() > b[i + 1].innerText.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                } else {
                    if (b[i].innerText.toLowerCase() < b[i + 1].innerText.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
            }
            if (shouldSwitch) {
                b[i].parentNode.insertBefore(b[i + 1], b[i]);
                switching = true;
            }
        }
        // Toggle the sort state after sorting
        isAscending = !isAscending;
        // Change the sort icon after sorting
        let sortButton = document.getElementById("sortButton");
        if (isAscending) {
            sortButton.innerHTML = '<i class="fas fa-sort-up"></i> Sort';
        } else {
            sortButton.innerHTML = '<i class="fas fa-sort-down"></i> Sort';
        }
    }



    document.getElementById('create-channel').addEventListener('click', function(){
        document.getElementById('channelName').value = document.getElementById('channelName').value.trim();
        var channelName = document.getElementById('channelName').value;
        if(channelName === ""){
            document.getElementById('error-message').style.display = 'block';
        } else {
            document.getElementById('error-message').style.display = 'none';

            fetch('database/addchannel?format=raw', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    channelName: channelName
                })
            })
                .then(response => response.json())
                .then(data => {
                    //console.log(data);
                    alert(data.message);
                    // Hide modal after successful operation
                    document.getElementById('newChannelModal').style.display='none';
                    loadChannels();
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }
    });

</script>