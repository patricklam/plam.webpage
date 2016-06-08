class List<T>
{
    private ListEntry head;
    private ListEntry tail;

    class ListEntry
    {
        private T data;
        private ListEntry next;
        public ListEntry(T d)
        {
            data = d;
            next = null;
        }

        public T getData() { return data; }
		public void setData(T data) { this.data = data; }

		public ListEntry getNext() { return next; }
		public void setNext(ListEntry next) { this.next = next; }

		@Override
        public String toString()
        {
            return data.toString();
        }
    }

    public List()
    {
        head = null;
        tail = null;
    }

    public T getHead() { return head.getData(); }
	public T getTail() { return tail.getData(); }
    public boolean isEmpty() { return head == null; }
	public void clear() { head = null; tail = null; }

	public void append(T i)
    {
        ListEntry tmp = new ListEntry(i);
        tmp.next = null;
        if (head == null)
        {
            head = tmp;
        }
        else
        {
            tail.setNext(tmp);
        }
        tail = tmp;
    }

    public void prepend(T i)
    {
        ListEntry tmp = new ListEntry(i);
        tmp.next = head;
        if (head == null)
        {
            tail = tmp;
        }
        head = tmp;
    }

    public T removeFirstItem()
    {
        // returns the first element on the list or
        // throws UnsupportedOperationException if the list is empty
        ListEntry tmp;
        if (head == null)
            throw new UnsupportedOperationException();
        else
        {
            tmp = head;
            head = head.getNext();
            return tmp.getData();
        }
    }
}
