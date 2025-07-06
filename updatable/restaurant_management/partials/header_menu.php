<!-- Header -->
<header class="main-header"  >
    <!-- Logo -->
    <a href="" class="logo" style="background-color:magenta">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>RMS</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>POS System</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" style="background-color:#da70d6">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Message box -->
        <div class="navbar-custom-menu" style="margin-right:20px;">
            <ul class="nav navbar-nav">
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success" id="notificationCount">0</span>
                    </a>
                    <!-- Message dropdown menu -->
                    <ul class="dropdown-menu">
                        <li class="header">You have <span id="notificationCountText">0</span> notifications</li>
                        <li id="notificationList">
                            <!-- Inner message items -->
                        </li>
                        <li class="footer"><a href="#">See All Messages</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>

<!-- Add your WebSocket code here -->
<script>
    const socket = new WebSocket('ws://localhost:8080');

    socket.addEventListener('message', (event) => {
        const orderDataArray = JSON.parse(event.data);
        console.log('Order data array:', JSON.stringify(orderDataArray));

        orderDataArray.forEach(orderData => {
            console.log('Order received:', orderData);
            displayNotification(orderData);
        });
    });

    function displayNotification(orderData) {
        const notificationList = document.getElementById('notificationList');
        const notificationCount = document.getElementById('notificationCount');
        // Create a new list item for the notification
        const notificationItem = document.createElement('li');
        notificationItem.innerHTML = `Order received:<br>` +
            `ID: ${orderData.id}<br>` +
            `Product: ${orderData.product}<br>` +
            `Price: ${orderData.price}<br>` +
            `Quantity: ${orderData.quantity}<br>`;
            
        notificationList.insertBefore(notificationItem, notificationList.firstChild);

        // Increment the notification count
        const notificationCountText = document.getElementById('notificationCountText');
        let count = parseInt(notificationCount.textContent) + 1;
        notificationCount.textContent = count;
        notificationCountText.textContent = count;

        // Clear notifications after 5 minutes
        setTimeout(() => {
            notificationList.innerHTML = '';
            notificationCount.textContent = '0';
            notificationCountText.textContent = '0';
        }, 300000); // 5 minutes in milliseconds
    }

    function acceptOrder(orderId) {
        // Implement accept order functionality here
        console.log(`Order ${orderId} accepted`);
    }

    function rejectOrder(orderId) {
        // Implement reject order functionality here
        console.log(`Order ${orderId} rejected`);
    }
</script>
