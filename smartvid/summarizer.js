
const GEMINI_API_KEY = "AIzaSyDUyaUZmYHvoga2s3T5a9ElRpzBJWlpOe8";
const API_ENDPOINT = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" + GEMINI_API_KEY;
const MODEL_NAME = "gemini-2.5-flash"; // A model that supports multimodal input

document.getElementById('summaryButton').addEventListener('click', summarizeVideo);

async function summarizeVideo() {
    const youtubeLink = document.getElementById('youtubeLink').value.trim();
    const summaryOutput = document.getElementById('summaryOutput');
    const statusMessage = document.getElementById('statusMessage');

    // 1. Basic input validation
    if (!youtubeLink) {
        summaryOutput.innerHTML = 'Please enter a valid YouTube link.';
        return;
    }

    // A basic check to see if it looks like a YouTube URL
    if (!youtubeLink.includes('youtube.com/') && !youtubeLink.includes('youtu.be/')) {
        summaryOutput.innerHTML = 'The link does not appear to be a YouTube URL.';
        return;
    }
    
    // 2. Prepare UI for loading state
    summaryOutput.innerHTML = 'Summarizing...';
    statusMessage.innerHTML = 'Sending request to Gemini AI. This may take a moment.';
    document.getElementById('summaryButton').disabled = true;

    // 3. Construct the API request body
// Inside the async function summarizeVideo() in summarizer.js

    // 3. Construct the API request body
    const requestBody = {
        contents: [
            {
                role: "user",
                parts: [
                    {
                        text: "Please provide a detailed and comprehensive summary of this YouTube video. Use Markdown to structure the summary with clear headings and bullet points. **Crucially, ensure all key terms, main topics, and most important takeaways are bolded using double asterisks (**).**",                    
                    },
                    {
                        fileData: {
                            // Using the URL from the input field
                            fileUri: youtubeLink,
                            // Mime type for video input via URL
                            mimeType: "video/mp4", 
                        }
                    }
                ]
            }
        ],
        // ⭐️ THE FIX: The API requires 'generationConfig' (with an 'n') 
        generationConfig: {
            temperature: 0.2
        }
    };

// ...

    // 4. Send the request to the Gemini API
    try {
        const response = await fetch(API_ENDPOINT, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(requestBody)
        });

        // 5. Handle the API response
        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(`API error: ${errorData.error.message || response.statusText}`);
        }

        const data = await response.json();
        
        // Extract the generated text from the response structure
        const summaryText = data?.candidates?.[0]?.content?.parts?.[0]?.text || "Sorry, I could not generate a summary for this video.";

        // 6. Update the UI with the summary
        summaryOutput.innerHTML = summaryText;
        statusMessage.innerHTML = 'Summary successfully generated.';

    } catch (error) {
        // 7. Handle any errors
        console.error("Error summarizing video:", error);
        summaryOutput.innerHTML = `An error occurred: ${error.message}. Please check the YouTube link and your API key.`;
        statusMessage.innerHTML = 'Failed to generate summary.';
    } finally {
        // 8. Restore button state
        document.getElementById('summaryButton').disabled = false;
    }
}