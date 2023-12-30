
// capture payment
app.post("/api/orders", async (req, res) => {
    	  const order = await paypal.createOrder(req.body.paymentSource);
    	  res.json(order);
    	});

app.post("/api/orders/:orderID/capture", async (req, res) => {
    const { orderID } = req.params;
    const captureData = await paypal.capturePayment(orderID);
    res.json(captureData);
  });
      