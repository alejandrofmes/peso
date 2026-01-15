<x-empty-layout>

    <iframe src="{{ asset('storage/' . $pdfPath) }}" type="application/pdf" width="100%" height="100%"
        style="position: absolute; top: 0; left: 0; border: none;">
        This browser does not support PDFs. Please download the PDF to view it: <a
            href="{{ asset('storage/' . $pdfPath) }}">Download PDF</a>.
    </iframe>


</x-empty-layout>
