<script>
    const socket = new WebSocket('ws://localhost:8080');

    // Connection opened
    socket.addEventListener('open', (event) => {
        console.log('WebSocket connection opened:', event);
    });

    // Listen for messages from the ordering page
    socket.addEventListener('message', (event) => {
        const orderDetails = event.data;
        alert('Order received:'+ event.data);
        console.log(orderDetails);

        // Process the order data as needed on the admin page
        // You can update the UI, store the data, or perform any other actions
    });

    // Connection closed
    socket.addEventListener('close', (event) => {
        console.log('WebSocket connection closed:', event);
    });
</script>