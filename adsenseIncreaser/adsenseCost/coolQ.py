from kombu import BrokerConnection


class coolQ(object):

    def __init__(self, connection, queue_name="coolQ_queue",
            serializer="json", compression=None):
		self.queue_name = queue_name
		self.queue = connection.SimpleQueue(self.queue_name)
		self.serializer = serializer
		self.compression = compression
		self.connection = connection

    def ad2q(self, ad, context={}):
        self.queue.put(ad,
                        serializer=self.serializer,
                        compression=self.compression)

    def process(self, n=1, timeout=1):
        # for i in xrange(n):
            # try:
				# log_message = self.queue.get(block=True, timeout=1)
				# entry = log_message.payload # deserialized data.
				# callback(entry)
				# log_message.ack() # remove message from queue
            # except:
				# break
		try:
				log_message = self.queue.get(block=True, timeout=1)
				entry = log_message.payload # deserialized data.	
				log_message.ack() # remove message from queue
				return entry
		except:
				return None
				
	# def process1(self, n=1, timeout=1):
            # try:
				# log_message = self.queue.get(block=True, timeout=1)
				# entry = log_message.payload # deserialized data.	
				# log_message.ack() # remove message from queue
				# return entry
            # except:
				# return None

    def close(self):
        self.connection.close()
        self.queue.close()


if __name__ == "__main__":
    connection = BrokerConnection(hostname="localhost",
                                  userid="guest",
                                  password="guest",
                                  virtual_host="/")
    logger = coolQ(connection)

    # Send message
    logger.ad2q(["dsf","sdfsdf"])
    #logger.log("Error happened while encoding video",
    #           level="ERROR",
    #           context={"filename": "cutekitten.mpg"})

    # Consume and process message

    # This is the callback called when a log message is
    # received.
    def dump_entry(entry):
        date = 'foo'
        print("[%s %s %s] %s %r" % (date,
                                    entry["hostname"],
                                    entry["level"],
                                    entry["message"],
                                    entry["context"]))

    # Process a single message using the callback above.
    logger.process(n=1)

    #logger.close()