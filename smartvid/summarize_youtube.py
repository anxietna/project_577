# 1. Installation: Run these two lines in your Python environment (e.g., Colab or terminal) first:
# !pip install google-genai

import os
from google import genai
from google.genai import types

# --- Configuration ---
# ⚠️ IMPORTANT: Replace "YOUR_GEMINI_API_KEY" with your actual key. 
# It's best practice to load this from an environment variable (os.environ.get("GEMINI_API_KEY")).
GEMINI_API_KEY = "AIzaSyDUyaUZmYHvoga2s3T5a9ElRpzBJWlpOe8" 
YOUTUBE_URL = "https://www.youtube.com/watch?v=kCpfsypEnIc" # Replace with the video you want to summarize

def summarize_youtube_video(api_key: str, url: str):
    """
    Connects to the Gemini API and generates a summary from a YouTube URL.
    """
    try:
        # Initialize the Gemini Client
        # The client will automatically pick up the API key from the environment 
        # variable GEMINI_API_KEY if it's set, or you can pass it directly.
        client = genai.Client(api_key=GEMINI_API_KEY)
        
        print(f"--- Summarizing Video: {url} ---")
        print("Sending video URL to Gemini 2.5 Flash. This may take a moment...")

        # 2. Define the Prompt and the Video File Data
        # We create a list of parts: a text prompt and the file data (the YouTube URL)
        contents = [
            # The prompt to guide the AI's summary style and content
            types.Part.from_text(
                "Please provide a comprehensive summary of this YouTube video. "
                "Structure your response with a brief introduction, bulleted main points, and a conclusion."
            ),
            # The video data part, using the URL as the file_uri
            types.Part.from_uri(
                file_uri=url,
                mime_type="video/mp4", # Use a common video MIME type
            ),
        ]
        
        # 3. Call the API
        response = client.models.generate_content(
            model="gemini-2.5-flash", # A fast, capable multimodal model
            contents=contents,
        )

        # 4. Print the Summary
        print("\n" + "="*50)
        print("✨ AI-Generated Summary ✨")
        print("="*50)
        print(response.text)
        print("="*50 + "\n")

    except Exception as e:
        print(f"\nAn error occurred: {e}")
        print("Please check your API key, ensure the URL is valid, and confirm the video is accessible.")

if __name__ == "__main__":
    # Ensure you set your actual API key here or as an environment variable
    summarize_youtube_video(GEMINI_API_KEY, YOUTUBE_URL)

   


