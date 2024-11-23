import React, { useState } from 'react';
import { X, BookOpen, Calendar, Barcode } from 'lucide-react';

const BookCategory = () => {
  const [selectedBook, setSelectedBook] = useState(null);
  const [isModalOpen, setIsModalOpen] = useState(false);

  const [borrowFormData, setBorrowFormData] = useState({
    id_number: '',
    course: '',
    department: 'COT'
  });
  const [showBorrowModal, setShowBorrowModal] = useState(false);
  const [selectedBookId, setSelectedBookId] = useState(null);

  const bookCategoryContainer = document.getElementById('react-book-category');
  const category = JSON.parse(bookCategoryContainer.dataset.category);
  const books = JSON.parse(bookCategoryContainer.dataset.books);

  const truncateText = (text, maxLength) => {
    if (!text || text.length <= maxLength) return text;
    const truncated = text.substr(0, maxLength).split(' ').slice(0, -1).join(' ');
    return `${truncated}...`;
  };

  const borrowBook = async (bookId) => {
    try {
      const response = await fetch(`/books/borrow/${bookId}`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify(borrowFormData)
      });

      if (response.ok) {
        alert('Book borrowed successfully!');
        setShowBorrowModal(false);
        setBorrowFormData({
          id_number: '',
          course: '',
          department: 'COT'
        });
      } else {
        const errorData = await response.json();
        console.error('Error borrowing book:', errorData);
        alert(errorData.error || 'Failed to borrow the book.');
      }
    } catch (error) {
      console.error('Unexpected error:', error);
      alert('An unexpected error occurred.');
    }
  };

  const BookCard = ({ book }) => (
    <div className="flex flex-col h-full rounded-lg border bg-card shadow-sm hover:shadow-md transition-shadow duration-200">
      <div className="flex-1 p-6">
        <div className="flex justify-between items-start gap-2">
          <h3 className="text-xl font-semibold truncate flex-1" title={book.title}>
            {book.title}
          </h3>
          <span className="text-sm text-muted-foreground whitespace-nowrap">
            {book.published_year}
          </span>
        </div>

        <p className="text-sm text-muted-foreground truncate mt-1" title={`By ${book.author}`}>
          By {book.author}
        </p>

        <p className="text-xs text-muted-foreground mt-2 flex items-center gap-1">
          <Barcode className="h-3 w-3" />
          {book.isbn}
        </p>

        <div className="mt-4">
          <p className="text-gray-700">
            {truncateText(book.description || 'No description available.', 100)}
            {book.description && book.description.length > 100 && (
              <button
                onClick={(e) => {
                  e.preventDefault();
                  setSelectedBook(book);
                  setIsModalOpen(true);
                }}
                className="ml-2 text-primary hover:underline font-medium"
              >
                See More
              </button>
            )}
          </p>
        </div>
      </div>

      <div className="p-6 border-t mt-auto">
        <div className="flex items-center justify-between gap-4">
          <span className="text-sm text-muted-foreground">
            {book.quantity > 0 ? (
              <span className="text-green-600">
                {book.quantity} {book.quantity === 1 ? 'copy' : 'copies'} available
              </span>
            ) : (
              <span className="text-red-600">
                Out of stock
              </span>
            )}
          </span>
          <button
            onClick={() => {
              setSelectedBookId(book.id);
              setShowBorrowModal(true);
            }}
            disabled={book.quantity <= 0}
            className="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
          >
            <BookOpen className="w-4 h-4 mr-2" />
            Borrow
          </button>
        </div>
      </div>
    </div>
  );

  return (
    <div className="container mx-auto px-4 py-8">
      <div className="mb-8">
        <h1 className="text-3xl font-bold">
          Books in the "{category.name}" Category
        </h1>
        <p className="text-muted-foreground mt-2">
          Showing {books.length} available {books.length === 1 ? 'book' : 'books'} in this category
        </p>
      </div>

      {books.length > 0 ? (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {books.map((book) => (
            <BookCard key={book.id} book={book} />
          ))}
        </div>
      ) : (
        <div className="text-center py-12">
          <p className="text-lg text-gray-600">No books available in this category.</p>
        </div>
      )}

      {/* Book Details Modal */}
      {isModalOpen && selectedBook && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div
            className="fixed inset-0 bg-black bg-opacity-50 transition-all duration-100"
            onClick={() => setIsModalOpen(false)}
          />

          <div className="relative bg-white rounded-lg shadow-lg max-h-[90vh] overflow-y-auto w-full max-w-2xl mx-4 animate-in fade-in-0 zoom-in-95">
            <div className="p-6">
              <button
                onClick={() => setIsModalOpen(false)}
                className="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2"
              >
                <X className="h-4 w-4" />
                <span className="sr-only">Close</span>
              </button>

              <div className="space-y-4">
                <div className="flex items-start justify-between gap-4">
                  <h2 className="text-2xl font-bold">{selectedBook.title}</h2>
                  <span className="text-sm text-muted-foreground whitespace-nowrap">
                    {selectedBook.published_year}
                  </span>
                </div>

                <div className="space-y-1">
                  <p className="text-lg text-muted-foreground">
                    By {selectedBook.author}
                  </p>
                  <p className="text-sm text-muted-foreground flex items-center gap-1">
                    <Barcode className="h-3 w-3" />
                    {selectedBook.isbn}
                  </p>
                </div>

                <div>
                  <h3 className="text-lg font-semibold mb-2">Description</h3>
                  <p className="text-gray-700 whitespace-pre-line">
                    {selectedBook.description || 'No description available.'}
                  </p>
                </div>

                <div className="pt-4 border-t">
                  <div className="flex items-center justify-between mb-4">
                    <h3 className="text-lg font-semibold">Availability</h3>
                    <span className={`text-sm ${selectedBook.quantity > 0 ? 'text-green-600' : 'text-red-600'}`}>
                      {selectedBook.quantity > 0 ? (
                        `${selectedBook.quantity} ${selectedBook.quantity === 1 ? 'copy' : 'copies'} available`
                      ) : (
                        'Currently out of stock'
                      )}
                    </span>
                  </div>

                  <button
                    onClick={() => {
                      setSelectedBookId(selectedBook.id);
                      setShowBorrowModal(true);
                      setIsModalOpen(false);
                    }}
                    disabled={selectedBook.quantity <= 0}
                    className="w-full inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
                  >
                    <BookOpen className="w-4 h-4 mr-2" />
                    Borrow Now
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      )}

      {/* Borrow Modal */}
      {showBorrowModal && (
        <div className="fixed inset-0 z-50 flex items-center justify-center">
          <div
            className="fixed inset-0 bg-black bg-opacity-50 transition-all duration-100"
            onClick={() => setShowBorrowModal(false)}
          />
          <div className="relative bg-white rounded-lg shadow-lg max-h-[90vh] w-full max-w-md mx-4 animate-in fade-in-0 zoom-in-95">
            <div className="p-6">
              <h3 className="text-xl font-semibold mb-4">Borrow Book</h3>
              <form onSubmit={(e) => {
                e.preventDefault();
                borrowBook(selectedBookId);
              }}>
                <div className="space-y-4">
                  <div>
                    <label className="block text-sm font-medium mb-1">ID Number</label>
                    <input
                      type="text"
                      required
                      className="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                      value={borrowFormData.id_number}
                      onChange={(e) => setBorrowFormData({ ...borrowFormData, id_number: e.target.value })}
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium mb-1">Course</label>
                    <input
                      type="text"
                      required
                      className="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                      value={borrowFormData.course}
                      onChange={(e) => setBorrowFormData({ ...borrowFormData, course: e.target.value })}
                    />
                  </div>
                  <div>
                    <label className="block text-sm font-medium mb-1">Department</label>
                    <select
                      required
                      className="flex h-10 w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-gray-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                      value={borrowFormData.department}
                      onChange={(e) => setBorrowFormData({ ...borrowFormData, department: e.target.value })}
                    >
                      <option value="COT">COT</option>
                      <option value="COE">COE</option>
                      <option value="CEAS">CEAS</option>
                      <option value="CME">CME</option>
                    </select>
                  </div>
                </div>
                <div className="mt-6 flex justify-end space-x-3">
                  <button
                    type="button"
                    onClick={() => setShowBorrowModal(false)}
                    className="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-gray-300 bg-white hover:bg-gray-50 h-10 px-4 py-2"
                  >
                    Cancel
                  </button>
                  <button
                    type="submit"
                    className="inline-flex items-center justify-center rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2"
                  >
                    Borrow
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      )}
    </div>
  );
};

export default BookCategory;