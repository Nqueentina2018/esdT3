import sys
import os
import csv

# Communication pattern:
# Use a message-broker with 'direct' exchange to enable interaction
# send message to the specific queue where the customer UI service will pick up the message 
import pika

hostname = "localhost" # default hostname
port = 5672 # default port

# connect to the broker and set up a communication channel in the connection
connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
channel = connection.channel()
# set up the exchange if the exchange doesn't exist
exchangename="ui_direct"
channel.exchange_declare(exchange=exchangename, exchange_type='direct')


def receive():
    # prepare a queue for "notification" service to receive messages
    channelqueue = channel.queue_declare(queue="notification", durable=True)
    queue_name = channelqueue.method.queue
    channel.queue_bind(exchange=exchangename, queue=queue_name, routing_key='notification')

    # set up a consumer and wait for coming messages from both UI and order
    # "pending" and "confirmed" messages respectively
    channel.basic_qos(prefetch_count=1)
    channel.basic_consume(queue=queue_name, on_message_callback=callback, auto_ack=True)
    channel.start_consuming() # waiting to receive messages


def callback(channel, method, properties, body): # required signature for the callback; no return
    # result contains what the "notification service" receive in its queue

    # for now, assume that the message will be sent to the queue in json format
    result = create_msg(json.loads(body))
    # print processing result; not really needed
    json.dump(result, sys.stdout, default=str)
    print()


def create_msg(content):
    print("Creating a notification message:")
    print(content)
    # determine if "pending" or "order created"
    status = content['order_status']
    order_id = content['order_id']
    if status == "pending":      # need to check how the OBTOS UI will send the message to the notification
        result = {'status': status, 'message': 'Your order is pending. Please Wait', 'order_id': order_id}
    else:
        result = {'status': status, 'message': 'Your order is confirmed.', 'order_id': order_id}
    print("Notification created.")
    return result

# to set up the exchange for "notification"
# to send notification to the UI, we need to send the orderid and the message corresponding to it
# so need to confirm what format will the queue for "OBTOS UI" service like to receive in
def send_notification(message):
    # default hostname and port
    hostname = "localhost"
    port = 5672

    # connect to the broker and set up a communication channel in the connection
    connection = pika.BlockingConnection(pika.ConnectionParameters(host=hostname, port=port))
    channel = connection.channel()

    # set up the exchange for notification service
    exchangename = "ui_direct"
    channel.exchange_declare(exchange=exchangename, exchange_type='direct')
    
    # send the message to the OBTOS UI
    # always inform the customer whether the order is pending, successful or not
    channel.basic_publish(exchange=exchangename, routing_key="customer.order", body=message)

    print("Notification sent to the specific customer.")
    connection.close()

if __name__ == "__main__":
    print("This is " + os.path.basename(__file__) + ": sending notification to a customer...")
    receive()   # Receive the message from its queue to start its functions
    send_notification()









