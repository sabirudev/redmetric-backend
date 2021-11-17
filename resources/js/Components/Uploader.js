import React from 'react'

export default function Uploader() {
    return (
        <section className="h-full overflow-auto p-2 w-full flex flex-col">
            <header className="border-dashed border-2 border-gray-400 py-12 flex flex-col justify-center items-center">
                <p className="mb-3 font-semibold text-gray-900 flex flex-wrap justify-center">
                    <span>Drag and drop your</span>&nbsp;<span>files anywhere or</span>
                </p>
                <input id="hidden-input" type="file" multiple className="hidden" />
                <button id="button" className="mt-2 rounded-sm px-3 py-1 bg-gray-200 hover:bg-gray-300 focus:shadow-outline focus:outline-none">
                    Upload a file
                </button>
            </header>
        </section>
    )
}