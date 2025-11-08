<?php
// Debug CKEditor Loading Issue
echo "=== CKEditor Loading Issue Debug ===\n\n";

echo "PROBLEM IDENTIFIED:\n";
echo "❌ CodeBox utility loaded before CKEditor initialization\n";
echo "❌ Potential JavaScript error preventing CKEditor from loading\n";
echo "❌ Loading order issue causing conflicts\n\n";

echo "ROOT CAUSE:\n";
echo "1. CodeBox utility script loaded at line 124\n";
echo "2. CKEditor initialization happens in setTimeout at line 152\n";
echo "3. CodeBox utility might be trying to access ClassicEditor before it's ready\n";
echo "4. Any JavaScript error can prevent CKEditor from initializing\n\n";

echo "SOLUTION NEEDED:\n";
echo "1. Move CodeBox utility loading inside CKEditor initialization\n";
echo "2. Add better error handling\n";
echo "3. Ensure proper loading order\n";
echo "4. Add fallback if CodeBox fails to load\n\n";

echo "FIXES TO APPLY:\n";
echo "1. Remove script tag from line 124\n";
echo "2. Load CodeBox utility after CKEditor is initialized\n";
echo "3. Add try-catch blocks around CodeBox initialization\n";
echo "4. Add debug logging to track the issue\n";