<x-empty-layout>
    <div class="relative h-screen">
        <iframe src="{{ asset('storage/' . $pdfPath) }}" type="application/pdf"
            class="absolute inset-0 w-full h-full border-none">
            This browser does not support PDFs. Please download the PDF to view it:
            <a href="{{ asset('storage/' . $pdfPath) }}">Download PDF</a>.
        </iframe>

        <!-- Button positioned on top of the iframe -->
        <div class="absolute top-4 right-4">
            <button onclick="downloadPDF()"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                Download PDF
            </button>
        </div>
    </div>

    <script>
        function downloadPDF() {
            const link = document.createElement('a');
            link.href = "{{ asset('storage/' . $pdfPath) }}";
            link.download = 'Your_Custom_File_Name.pdf'; // Set your custom file name here
            link.click();
        }
    </script>
</x-empty-layout>
